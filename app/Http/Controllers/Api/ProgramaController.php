<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Programa;
use App\Utils\ReplicadoTemp;
use Uspdev\Replicado\Posgraduacao;
use Uspdev\Replicado\Lattes;
use App\Models\Lattes as LattesModel;
use App\Utils\Util;

class ProgramaController extends Controller
{
    public function index(){
        $programas = Programa::index()['programas'];
        $departamentos = Programa::index()['departamentos'];
        foreach($departamentos as $dep){
            unset($dep->codpes_docentes);
        }
        
        return response()->json(
           ['programas' => $programas, 'departamentos' => $departamentos],
            200, [], JSON_UNESCAPED_UNICODE
        );
    }
    
    public function obterOrcid(){
        return response()->json(
            Programa::obterOrcid(),
            200, [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
    }

    public function listarDocentes($codare, Request $request){
        
        $filtro = Programa::getFiltro($request);   
        if(isset(Util::departamentos[$codare]) ){
            $departamento = Programa::where('codare', 0)->get()->first();
            $json = json_decode($departamento->json, true);
            $departamento = array_values(array_filter($json, function($a) use ($codare) { return $a['sigla'] == $codare; }))[0];
            $docentes = Programa::listarPessoa($departamento['codpes_docentes'], $filtro, false, 'docentes', false);
        }else{
            $model_programa = Programa::where('codare', $codare)->get()->first();
            $json = json_decode($model_programa->json, true);
            $docentes = Programa::listarPessoa($json['docentes'], $filtro, false, 'docentes', false);
        }
        
        return response()->json(
            $docentes
        );
    }
    public function listarDiscentes($codare, Request $request){
        
        $filtro = Programa::getFiltro($request);        
        $model_programa = Programa::where('codare', $codare)->get()->first();
        $json = json_decode($model_programa->json, true);
        $discentes = Programa::listarPessoa($json['discentes'], $filtro, false, 'discentes', false);

        return response()->json(
            $discentes
        );
    }
    public function listarEgressos($codare, Request $request){
        
        $filtro = Programa::getFiltro($request);        
        $model_programa = Programa::where('codare', $codare)->get()->first();
        $json = json_decode($model_programa->json, true);
        $egressos = Programa::listarPessoa($json['egressos'], $filtro, false, 'egressos', false);

        return response()->json(
            $egressos
        );
    }

    public function docente($id_lattes, Request $request) {

       
        $codpes = Lattes::retornarCodpesPorIDLattes($id_lattes);

        $filtro = Programa::getFiltro($request);        
        $content = Programa::obterPessoa($codpes, $filtro, true, 'docentes');
        
        return response()->json(
            $content
        );
    }
    public function discente($id_lattes, Request $request) {
        $codpes = Lattes::retornarCodpesPorIDLattes($id_lattes);

        $filtro = Programa::getFiltro($request);        
        $content = Programa::obterPessoa($codpes, $filtro, true, 'discentes');
        
        return response()->json(
            $content
        );
    }
    public function egresso($id_lattes, Request $request) {       
        $codpes = Lattes::retornarCodpesPorIDLattes($id_lattes);

        $filtro = Programa::getFiltro($request);        
        $content = Programa::obterPessoa($codpes, $filtro, true, 'egressos');
        
        return response()->json(
            $content
        );
    }
}
