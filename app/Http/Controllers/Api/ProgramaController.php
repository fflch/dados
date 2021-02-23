<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Programa;
use App\Utils\ReplicadoTemp;
use Uspdev\Replicado\Posgraduacao;


class ProgramaController extends Controller
{
    public function index(){
        return response()->json(
            Programa::index()
        );
    }

    public function listarDocentes($codare, Request $request){
        
        $filtro = Programa::getFiltro($request);     
        $docentes = ReplicadoTemp::credenciados($codare);   
        $docentes = Programa::listarPessoa($codare, $filtro, $docentes, true, 'docente');
        
        return response()->json(
            $docentes
        );
    }
    public function listarDiscentes($codare, Request $request){
        
        $filtro = Programa::getFiltro($request);   
        $discentes = Posgraduacao::obterAtivosPorArea($codare, 8);      
        $discentes = Programa::listarPessoa($codare, $filtro, $discentes, true, 'discente');

        return response()->json(
            $discentes
        );
    }
    public function listarEgressos($codare, Request $request){
        
        $filtro = Programa::getFiltro($request);       
        $egressos = Posgraduacao::egressosArea($codare, 8);  
        $egressos = Programa::listarPessoa($codare, $filtro, $egressos, true, 'egresso');
        
        return response()->json(
            $egressos
        );
    }

    public function docente($codpes, Request $request) {
        $filtro = Programa::getFiltro($request);        
        $content = Programa::obterPessoa($codpes, $filtro, true, 'docente');
        
        return response()->json(
            $content
        );
    }
    public function discente($codpes, Request $request) {
        $filtro = Programa::getFiltro($request);        
        $content = Programa::obterPessoa($codpes, $filtro, true, 'discente');
        
        return response()->json(
            $content
        );
    }
    public function egresso($codpes, Request $request) {
        $filtro = Programa::getFiltro($request);        
        $content = Programa::obterPessoa($codpes, $filtro, true, 'egresso');
        
        return response()->json(
            $content
        );
    }
}
