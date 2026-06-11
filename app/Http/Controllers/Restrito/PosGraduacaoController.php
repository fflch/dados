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

use App\Models\AlunoPos;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\PreDec;

class PosGraduacaoController extends Controller
{
    public function index(){
        Gate::authorize('admin');
        
        $aux_programas = Posgraduacao::programas(8);
        //eleiminar repetiçao de programas com varias areas;
        $programas = [];
        foreach ($aux_programas as $pr) {
            $programas[$pr["codcur"]]=$pr["nomcur"];
        };
        return view('restrito.posgraduacao', [ 'programas' => $programas]);
    }
    var $colNames =[
        'NUSP',
        'email',
        'nome' 
    ];
    
    function listarEleicao(Excel $excel, Request $request){
        Gate::authorize('admin');

        $request->validate(
            [
                'programas.*' =>  'integer',
                'tipo' =>  'alpha|max:4',
                'junto' =>  'alpha|size:5',
                'header' => 'alpha|size:6'

            ]
        );
        $programas = array_map('intval',$request->programas);
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
            
            $data = AlunoPos::select('codpes', 'email', 'nome')->whereIn("codPrograma",$programas)->get()->toArray();
            $data = Util::ordena(['codpes', 'email', 'nome'],$data);
            Log::debug($data);
            
            if ($header) {
                $export = new DadosExport([$data], $this->colNames);
                }else{
                $export = new DadosExportNoHeader([$data]);
            }
            $curso = "";
            //if (count($programas) == 1) $curso = PreDecoga.' - ';

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
        
        foreach ($programas as $programa) {
            
            $data = AlunoPos::select(['codpes', 'email','nome'])->where("codPrograma",$programa)->get()->toArray();

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
