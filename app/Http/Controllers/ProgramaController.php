<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Uspdev\Replicado\Posgraduacao;
use App\Utils\ReplicadoTemp;
use App\Models\Lattes as LattesModel;
use App\Models\Programa;

class ProgramaController extends Controller
{
    public function index(){
        return view('programas.index',[
            'programas' => Programa::index(),
        ]);
    }
    
    public function listarDocentes($codare, Request $request) {
        $filtro = Programa::getFiltro($request);        
        $programa = Posgraduacao::programas(8, null, $codare)[0];
        $credenciados = ReplicadoTemp::credenciados($codare);
        $credenciados = Programa::listarPessoa($codare, $filtro, $credenciados, false, 'docente');
        $titulo = "Docentes credenciados ao programa de " .$programa['nomcur'] .": " .count($credenciados);

        
        return view('programas.show',[
            'pessoas' => $credenciados,
            'programa' => $programa,
            'filtro' => $filtro,
            'titulo' => $titulo,
            'form_action' => "/programas/docentes/$codare",
            'tipo_pessoa' => "docentes"

        ]);
    }
    
    public function listarDiscentes($codare, Request $request) {
        $filtro = Programa::getFiltro($request);        
        $programa = Posgraduacao::programas(8, null, $codare)[0];
        $discentes = Posgraduacao::obterAtivosPorArea($codare, 8); 
        $discentes = Programa::listarPessoa($codare, $filtro, $discentes, false, 'discente');
        $titulo = "Discentes ativos ao programa de ". $programa['nomcur'].": ".count($discentes);

        return view('programas.show',[
            'pessoas' => $discentes,
            'programa' => $programa,
            'filtro' => $filtro,
            'titulo' => $titulo,
            'form_action' => "/programas/discentes/$codare",
            'tipo_pessoa' => "discentes"

        ]);
    }

    public function listarEgressos($codare, Request $request) {
        $filtro = Programa::getFiltro($request);        
        $programa = Posgraduacao::programas(8, null, $codare)[0];
        $egressos = Posgraduacao::egressosArea($codare, 8); 
        $content_egressos = Programa::listarPessoa($codare, $filtro, $egressos, false, 'egresso');
        $titulo = "Egressos do programa de ".$programa['nomcur'].": ".count($egressos);
        
        return view('programas.show',[
            'pessoas' => $content_egressos,
            'programa' => $programa,
            'filtro' => $filtro,
            'titulo' => $titulo,
            'form_action' => "/programas/egressos/$codare",
            'tipo_pessoa' => "egressos"
        ]);
    }
    
    
    public function docente($codpes, Request $request) {
        $filtro = Programa::getFiltro($request);        
        $content = Programa::obterPessoa($codpes, $filtro,false, 'docente');
        $section_show = request()->section ?? '';

        return view('programas.pessoa',[
            'content' => $content,
            'section_show' => $section_show,
            'filtro' => $filtro,
            'form_action' => "/programas/docente/$codpes",
            'codpes' => $codpes
        ]);
    }

    public function discente($codpes, Request $request) {
        $filtro = Programa::getFiltro($request);        
        $content = Programa::obterPessoa($codpes, $filtro, false, 'discente');
        $section_show = request()->section ?? '';
        
        return view('programas.pessoa',[
            'content' => $content,
            'section_show' => $section_show,
            'filtro' => $filtro,
            'form_action' => "/programas/discente/$codpes"
        ]);
    }

    public function egresso($codpes, Request $request) {
        $filtro = Programa::getFiltro($request);        
        $content = Programa::obterPessoa($codpes, $filtro, false, 'egresso');
        $section_show = request()->section ?? '';
        
        return view('programas.pessoa',[
            'content' => $content,
            'section_show' => $section_show,
            'filtro' => $filtro,
            'form_action' => "/programas/egresso/$codpes"
        ]);
    }
}
