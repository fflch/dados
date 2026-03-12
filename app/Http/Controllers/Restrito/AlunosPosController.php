<?php

namespace App\Http\Controllers\Restrito;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;

use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use App\Exports\DadosExportNoHeader;
use Uspdev\Replicado\Posgraduacao;
use App\Utils\Util;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class AlunosPosController extends Controller
{
    var $colNames =[
        'NUSP',
        'email',
        'nome' 
    ];
    
    function listarPlanilha(Excel $excel, Request $request){
        Gate::authorize('admin');

        $programas = $request->programas;
        $tipo = $request->tipo;
        $junto = $request->junto == "junto";
        $todos = $request->todosprogramas == "todos";

        $header = $request->header == "header";

        if ($tipo != "csv" && $tipo != "xlsx") {
            abort(400,'Tipo inválido');
        }
        

        if (is_null($programas)) {
            abort(400,'insira um programa válido');
        }
   
        //baixar todas as areas no mesmo arquivo
        if ($junto || count($programas) ==1) {
            //encontrar as areas dos programas
            $todasAreas = Posgraduacao::programas(8);
            $areas = [];
            foreach ($todasAreas as $area) {
                if (in_array($area["codcur"],$programas)) {
                    $areas[] = $area; 
                }
            }
            if (empty($areas)) {
                abort(400,'programa inserido inválido');
            }

            $data = Util::query('listar_posgr_por_ano_e_area',[
                '__area__' => implode(", ",array_column($areas,"codare"))
            ]);

            if ($header) {
                $export = new DadosExport([$data], $this->colNames);
                }else{
                $export = new DadosExportNoHeader([$data]);
            }
            $curso = "";
            if (count($areas) == 1) $curso = $areas[0]["nomcur"].' - ';

            return $excel->download($export, $curso . 'Alunos de Pós-Graduação '.date('d-m-y').'.'.$tipo);   
        }

        // baixar areas em arquivos separados
        
        // criar pasta teporaria para os arquivos
        $temp = time();
        
        Storage::makeDirectory($temp);
        //criar zip
        $zip = new ZipArchive();
        $filename = storage_path("app/private/Alunos de Pós-Graduação - ".date('d-m-y').".zip");

        if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
            exit("cannot open <$filename>\n");
        }
        $todasAreas = Posgraduacao::areasProgramas();
        foreach ($programas as $programa) {

            $areas = $todasAreas[$programa]; //pega as areas de cada programa
            if (is_null($areas)) {
                abort(400,'insira um programa válido');
            }

            //buscar alunos
            $areas = implode(", ",array_column($areas,"codare"));
            $data = Util::query('listar_posgr_por_ano_e_area',[
                '__area__' => $areas
            ]);

            //gerar a planilha
            if ($header) {
                $export = new DadosExport([$data], $this->colNames);
                }else{
                $export = new DadosExportNoHeader([$data]);
            }
            $filepname= $temp."/".$programa.".".$tipo;
            $excel->store($export, $filepname );
            $zip->addFile(storage_path("app/private/".$filepname),"/".Posgraduacao::programas(8,$programa)[0]['nomcur'].".".$tipo);
        }
        $zip->close();
        Storage::deleteDirectory($temp);
        return response()->download($filename)->deleteFileAfterSend(true);

    }
    
}
