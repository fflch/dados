<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Uspdev\Replicado\Posgraduacao;
use App\Models\Programa;
use Uspdev\Replicado\Lattes;

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
        $credenciados = Programa::listarPessoa($codare, $filtro, false, 'docentes');
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
        $discentes = Programa::listarPessoa($codare, $filtro, false, 'discentes');
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
        $content_egressos = Programa::listarPessoa($codare, $filtro,  false, 'egressos');
        $titulo = "Egressos do programa de ".$programa['nomcur'].": ".count($content_egressos);
        
        return view('programas.show',[
            'pessoas' => $content_egressos,
            'programa' => $programa,
            'filtro' => $filtro,
            'titulo' => $titulo,
            'form_action' => "/programas/egressos/$codare",
            'tipo_pessoa' => "egressos"
        ]); 
    }
    
    
    public function docente($id_lattes, Request $request) {
        $codpes = Lattes::retornarCodpesPorIDLattes($id_lattes);
        $filtro = Programa::getFiltro($request);        
        $content = Programa::obterPessoa($codpes, $filtro,false, 'docentes');
        $section_show = request()->section ?? '';

        return view('programas.pessoa',[
            'content' => $content,
            'section_show' => $section_show,
            'filtro' => $filtro,
            'form_action' => "/programas/docente/$id_lattes",
            'codpes' => $codpes
        ]);
    }

    public function discente($id_lattes, Request $request) {
        $codpes = Lattes::retornarCodpesPorIDLattes($id_lattes);
        $filtro = Programa::getFiltro($request);        
        $content = Programa::obterPessoa($codpes, $filtro, false, 'discentes');
        $section_show = request()->section ?? '';
        
        return view('programas.pessoa',[
            'content' => $content,
            'section_show' => $section_show,
            'filtro' => $filtro,
            'form_action' => "/programas/discente/$id_lattes"
        ]);
    }

    public function egresso($id_lattes, Request $request) {
        $codpes = Lattes::retornarCodpesPorIDLattes($id_lattes);
        $filtro = Programa::getFiltro($request);        
        $content = Programa::obterPessoa($codpes, $filtro, false, 'egressos');
        $section_show = request()->section ?? '';
        
        return view('programas.pessoa',[
            'content' => $content,
            'section_show' => $section_show,
            'filtro' => $filtro,
            'form_action' => "/programas/egresso/$id_lattes"
        ]);
    }
}