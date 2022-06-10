<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Illuminate\Http\Request;
use Uspdev\Replicado\Posgraduacao;
use App\Models\Programa;
use Uspdev\Replicado\Lattes;
use App\Models\Lattes as LattesModel;
use App\Utils\Util;
use App\Utils\ReplicadoTemp;
use Uspdev\Replicado\Pessoa;

class ProgramaController extends Controller
{
    private $excel;

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
    }

    public function index(){
        $setores =  Programa::index();
       
        return view('programas.index',[
            'programas' => $setores[0],
            'departamentos' => $setores[1]
        ]);
    }

    
    public function listarDocentes($codare, Request $request) {
        $excel = isset($request->excel) ? $request->excel : false;     
        $filtro = Programa::getFiltro($request);   
        if(isset(Util::departamentos[$codare]) ){
            $programa = Util::departamentos[$codare][1];
            $departamento = Programa::where('codare', 0)->get()->first();
            $json = json_decode($departamento->json, true);
            $departamento = array_values(array_filter($json, function($a) use ($codare) { return $a['sigla'] == $codare; }))[0];
            $credenciados = Programa::listarPessoa($departamento['codpes_docentes'], $filtro, false, 'docentes', $excel);
            $titulo = "Docentes do departamento de " .$programa .": " .count($credenciados);
        }else{
            $programa = Posgraduacao::programas(8, null, $codare)[0];
            $model_programa = Programa::where('codare', $codare)->get()->first();
            $json = json_decode($model_programa->json, true);
            $credenciados = Programa::listarPessoa($json['docentes'], $filtro, false, 'docentes', $excel);
            $titulo = "Docentes credenciados ao programa de " .$programa['nomare'] .": " .count($credenciados);
        }
        
        if ($excel) {
            return $this->export($credenciados, 'docentes');
        }
        
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
        $excel = isset($request->excel) ? $request->excel : false;  
        $filtro = Programa::getFiltro($request);        
        $programa = Posgraduacao::programas(8, null, $codare)[0];
        $model_programa = Programa::where('codare', $codare)->get()->first();
        $json = json_decode($model_programa->json, true);
        $discentes = Programa::listarPessoa($json['discentes'], $filtro, false, 'discentes', $excel);
        $titulo = "Discentes ativos ao programa de ". $programa['nomare'].": ".count($discentes);

        if ($excel) {
            return $this->export($discentes, 'discentes');
        }

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
        $excel = isset($request->excel) ? $request->excel : false;  
        $filtro = Programa::getFiltro($request);        
        $programa = Posgraduacao::programas(8, null, $codare)[0];
        $model_programa = Programa::where('codare', $codare)->get()->first();
        $json = json_decode($model_programa->json, true);
     
        $content_egressos = Programa::listarPessoa($json['egressos'], $filtro,  false, 'egressos', $excel);
        $titulo = "Egressos do programa de ".$programa['nomare'].": ".count($content_egressos);
        
        if ($excel) {
            return $this->export($content_egressos, 'egressos');
        }

        return view('programas.show',[
            'pessoas' => $content_egressos,
            'programa' => $programa,
            'filtro' => $filtro,
            'titulo' => $titulo,
            'form_action' => "/programas/egressos/$codare",
            'tipo_pessoa' => "egressos"
        ]); 
    }

    private function export($pessoas, $tipo_pessoa)
    {
        $cabecalho = [];
        $cabecalho[] =  "ID Lattes";
        $cabecalho[] =  "Nome";
        if($tipo_pessoa == 'egressos'){
            $cabecalho[] =  "Nível Programa";
        }
        $cabecalho[] =  "Última Atualização Lattes";
        $cabecalho[] =  "Livros";
        $cabecalho[] =  "Artigos";
        $cabecalho[] =  "Capítulos de Livros";
        $cabecalho[] =  "Artigo em Jornal ou Revista";
        $cabecalho[] =  "Outras produções bibliográficas";
        $cabecalho[] =  "Trabalhos em anais";
        $cabecalho[] =  "Trabalhos Técnicos";
        if($tipo_pessoa == 'egressos'){
            $cabecalho[] =  "Formação Acadêmica";
            $cabecalho[] =  "Atuação Profissional";
        }
        $cabecalho[] =  "Organização de Eventos";
        $cabecalho[] =  "Curso de curta duração ministrado";
        $cabecalho[] =  "Relatório de pesquisa";
        $cabecalho[] =  "Matérial didático ou institucional";
        $cabecalho[] =  "Outras Produções Técnicas";
        $cabecalho[] =  "Projetos de Pesquisa";
        $cabecalho[] =  "Apresentações de Trabalho";
        $cabecalho[] =  "Programa de Rádio ou TV";
            
        $export = new DadosExport([$pessoas], $cabecalho);
        return $this->excel->download($export, 'download_excel.xlsx');
        
    }
    
    
    public function docente($id_lattes, Request $request) {
        $codpes = Lattes::retornarCodpesPorIDLattes($id_lattes);
        $filtro = Programa::getFiltro($request);        
        $content = Programa::obterPessoa($codpes, $filtro,false, 'docentes');
        $section_show = request()->section ?? '';

        
        if(sizeof($content) == 0){
            $request->session()->flash('alert-danger', "Dados do docente não encontrados");
            return redirect("/programas");
        }
        
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
        
        if(sizeof($content) == 0){
            $request->session()->flash('alert-danger', "Dados do discente não encontrados");
            return redirect("/programas");
        }

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
        
        if(sizeof($content) == 0){
            $request->session()->flash('alert-danger', "Dados do egresso não encontrados");
            return redirect("/programas");
        }

        return view('programas.pessoa',[
            'content' => $content,
            'section_show' => $section_show,
            'filtro' => $filtro,
            'form_action' => "/programas/egresso/$id_lattes"
        ]);
    }


}