<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Programa;
use App\Utils\ReplicadoTemp;
use Uspdev\Replicado\Posgraduacao;
use Uspdev\Replicado\Lattes;
use App\Models\Lattes as LattesModel;

class ProgramaController extends Controller
{
    public function index(){
        return response()->json(
            Programa::index()
        );
    }
    
    public function obterOrcid(){
        return response()->json(
            Programa::obterOrcid()
        );
    }

    public function listarDocentes($codare, Request $request){
        
        $filtro = Programa::getFiltro($request);     
        $docentes = Programa::listarPessoa($codare, $filtro,  true, 'docentes');
        
        return response()->json(
            $docentes
        );
    }
    public function listarDiscentes($codare, Request $request){
        
        $filtro = Programa::getFiltro($request);   
        $discentes = Programa::listarPessoa($codare, $filtro, true, 'discentes');

        return response()->json(
            $discentes
        );
    }
    public function listarEgressos($codare, Request $request){
        
        $filtro = Programa::getFiltro($request);       
        $egressos = Programa::listarPessoa($codare, $filtro, true, 'egressos');
        
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
