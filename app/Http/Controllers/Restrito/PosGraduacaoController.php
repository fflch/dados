<?php

namespace App\Http\Controllers\Restrito;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use App\Exports\DadosExportNoHeader;
use App\Models\ProjetoFapesp;
use Uspdev\Replicado\Posgraduacao;
use App\Utils\Util;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToArray;

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
        'Nome' ,
        'Nível',
        'Programa',
        'NUSP do Orientador',
        'Nome do Orientador'

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

            $data = Util::query('listar_posgr_eleicao',[
                '__area__' => implode(", ",array_column($areas,"codare"))
            ]);

            if ($header) {
                $export = new DadosExport([$data], ['NUSP', 'email', 'nome']);
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
            $data = Util::query('listar_posgr_eleicao',[
                '__area__' => $areas
            ]);

            //gerar a planilha
            if ($header) {
                $export = new DadosExport([$data], ['NUSP', 'email', 'nome']);
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

    
    function listar(Excel $excel, Request $request){
        Gate::authorize('admin');

        $request->validate(
            [
                'programas.*' =>  'integer',
                'tipo' =>  'alpha|max:4',
                'junto' =>  'alpha|size:5'

            ]
        );
        $programas = $request->programas;
        $tipo = $request->tipo;
        $junto = $request->junto == "junto";
        $todos = $request->todosprogramas == "todos";


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

            $data = Util::query('listar_posgr_ativos_orientador',[
                '__area__' => implode(", ",array_column($areas,"codare"))
            ]);

            $export = new DadosExport([$data], $this->colNames);
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
            $data = Util::query('listar_posgr_ativos_orientador',[
                '__area__' => $areas
            ]);

            //gerar a planilha
            $export = new DadosExport([$data], $this->colNames);
            $filepname= $temp."/".$programa.".".$tipo;
            $excel->store($export, $filepname );
            $zip->addFile(storage_path("app/private/".$filepname),"/".Posgraduacao::programas(8,$programa)[0]['nomcur'].".".$tipo);
        }
        $zip->close();
        Storage::deleteDirectory($temp);
        return response()->download($filename)->deleteFileAfterSend(true);

    }
    function fapespEstat(Excel $excel){
        $hoje = date('Y-m-d');

        // Buscando quantidade de bolsistas de Mestrado, Doutorado e Doutorado Direto
        $dataM = ProjetoFapesp::query()->select('programa', DB::raw('count(*) as bolsas'))
            ->where('nivel','mestrado')
            ->where('data_inicio','<=', $hoje)
            ->where('data_termino','>=', $hoje)
            ->groupBy('programa')->get()->ToArray();

        $dataD = ProjetoFapesp::query()->select('programa', DB::raw('count(*) as bolsas'))
            ->where('nivel','doutorado')
            ->where('data_inicio','<=', $hoje)
            ->where('data_termino','>=', $hoje)
            ->groupBy('programa')->get()->ToArray();

        $dataDD = ProjetoFapesp::query()->select('programa', DB::raw('count(*) as bolsas'))
            ->where('nivel','doutorado direto')
            ->where('data_inicio','<=', $hoje)
            ->where('data_termino','>=', $hoje)
            ->groupBy('programa')->get()->ToArray();


        //Organizando os dados
        $data = [];
        foreach ($dataM as $row) {
            $r = $row['programa'] ?? 'null';
            $data[$r] = [$row['programa'] ?? 0 , $row['bolsas']?? 0,0,0];
            
        }
        foreach ($dataD as $row) {
            if (is_null($row['programa'])) continue;

            $r = $row['programa'];
            if(array_key_exists($r,$data)){
                $data[$r][2] = $row['bolsas']?? 0;
            }else{
                $data[$r]=[$row['programa'] ?? 0 ,0, $row['bolsas'] ?? 0];
            }
        }
        foreach ($dataDD as $row) {
            if (is_null($row['programa'])) continue;

            $r = $row['programa'];
            if(array_key_exists($r,$data)){
                $data[$r][3] = $row['bolsas']?? 0;
            }else{
                $data[$r]=[$row['programa'] ?? 0 ,0,0, $row['bolsas'] ?? 0];
            }
        }

        //Log::alert($data);
        $export = new DadosExport([$data], ['programa', 'Mestrado','Doutorado', 'Doutorado Direto']);
        return $excel->download($export, 'Fapesp Pós-Graduação '.date('d-m-y').'.xlsx');   

    }

    function fapespLista(Excel $excel, Request $request){
        Gate::authorize('admin');

        $request->validate(
            [
                'programas.*' =>  'integer'
            ]
        );
        $prg = $request->programas;

        $aux_programas = Posgraduacao::programas(8);
        //eleiminar repetiçao de programas com varias areas;
        $todos_programas = [];
        foreach ($aux_programas as $pr) {
            $todos_programas[$pr["codcur"]]=$pr["nomcur"];
        };


        
        if (is_null($prg)) {
            abort(400,'insira um programa válido');
        }

        $programas = [];
        foreach ($prg as $pr) {
            if(isset($todos_programas[$pr])) $programas[] = $todos_programas[$pr] ;
        }

        $data = ProjetoFapesp::query()->select('nusp','bolsista','nivel','programa','pesquisador_responsavel','data_inicio','data_termino','updated_at')
            ->whereIn('programa',$programas)
            ->whereIn('nivel', ['mestrado', 'doutorado','doutorado direto'])
            ->orderBy('programa')
            ->orderBy('nivel')->get()->ToArray();


        $export = new DadosExport([$data], ['nusp','bolsista','nível','programa','pesquisador responsável','data início','data término','updated_at']);
        return $excel->download($export, 'Fapesp Pós-Graduação '.date('d-m-y').'.xlsx');   

    }

}
