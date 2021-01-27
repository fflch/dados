<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Uspdev\Replicado\Posgraduacao;
use Uspdev\Replicado\Lattes;
use Uspdev\Replicado\Pessoa;
use App\Utils\ReplicadoTemp;
use App\Models\Lattes as LattesModel;

class ProgramaController extends Controller
{
    public function index(){
        $programas = Posgraduacao::programas(8);
        return view('programas.index',[
            'programas' => $programas,
        ]);
    }

    public function show($codare, Request $request) {
        $tipo = $request->tipo;
        
        $filtro = ['tipo' => $tipo];
        switch($tipo){
            case 'anual':
                $filtro['limit_ini'] = $request->ano;
                $filtro['limit_fim'] = null;
                break;
            case 'periodo':
                $filtro['limit_ini'] = $request->ano_ini;
                $filtro['limit_fim'] = $request->ano_fim;
                break;
            case 'tudo':
                $filtro['tipo'] = 'tudo';
                $filtro['limit_ini'] = null;
                $filtro['limit_fim'] = null;
            break;
            default:
                $filtro['tipo'] = 'periodo';
                $filtro['limit_ini'] = 2017;
                    $filtro['limit_fim'] = 2020;
                break;
        }
        
        $programa = Posgraduacao::programas(8, null, $codare)[0];
        
        $credenciados = ReplicadoTemp::credenciados($codare);

        for($i = 0; $i < count($credenciados); $i++){

            #$json_lattes = LattesModel::where('codpes',$credenciados[$i]['codpes'])->first();
            #$lattes = $json_lattes ? json_decode($json_lattes->json,TRUE) : null;
            $lattes = Lattes::getArray($credenciados[$i]['codpes']); 
            
            $credenciados[$i]['href'] = "/programas/docente/".$credenciados[$i]['codpes'];
            $credenciados[$i]['href'] .= "?tipo=".$filtro['tipo']."&ano=".$filtro['limit_ini']."&ano_ini=".$filtro['limit_ini']."&ano_fim=".$filtro['limit_fim'];

            $credenciados[$i]['id_lattes'] = Lattes::id($credenciados[$i]['codpes']);
            $data_atualizacao = Lattes::getUltimaAtualizacao($credenciados[$i]['codpes'], $lattes) ; 
            $credenciados[$i]['data_atualizacao'] = $data_atualizacao ? substr($data_atualizacao, 0,2) . '/' . substr($data_atualizacao,2,2) . '/' . substr($data_atualizacao,4,4) : '-';
            
            $credenciados[$i]['total_livros'] = Lattes::getLivrosPublicados($credenciados[$i]['codpes'], $lattes, $filtro['tipo'], $filtro['limit_ini'], $filtro['limit_fim']);
            $credenciados[$i]['total_livros'] = $credenciados[$i]['total_livros'] ? count($credenciados[$i]['total_livros']) : '0';
            
            $credenciados[$i]['total_artigos'] = Lattes::getArtigos($credenciados[$i]['codpes'], $lattes, $filtro['tipo'], $filtro['limit_ini'], $filtro['limit_fim']);
            $credenciados[$i]['total_artigos'] = $credenciados[$i]['total_artigos'] ? count($credenciados[$i]['total_artigos']) : '0';
            
            $credenciados[$i]['total_capitulos'] = Lattes::getCapitulosLivros($credenciados[$i]['codpes'], $lattes, $filtro['tipo'], $filtro['limit_ini'], $filtro['limit_fim']);
            $credenciados[$i]['total_capitulos'] = $credenciados[$i]['total_capitulos'] ? count($credenciados[$i]['total_capitulos']) : '0';   

        }
        usort($credenciados, function ($a, $b) {
            return $a['nompes'] > $b['nompes'];
        });
        
        return view('programas.show',[
            'credenciados' => $credenciados,
            'programa' => $programa,
            'filtro' => $filtro,
            'form_action' => "/programas/$codare"
        ]);
    }

    public function docente($codpes, Request $request) {
        $tipo = $request->tipo;
        
        $filtro = ['tipo' => $tipo];
        switch($tipo){
            case 'anual':
                $filtro['limit_ini'] = $request->ano;
                $filtro['limit_fim'] = null;
                break;
            case 'periodo':
                $filtro['limit_ini'] = $request->ano_ini;
                $filtro['limit_fim'] = $request->ano_fim;
                break;
            case 'tudo':
                $filtro['tipo'] = 'tudo';
                $filtro['limit_ini'] = null;
                $filtro['limit_fim'] = null;
            break;
            default:
                $filtro['tipo'] = 'periodo';
                $filtro['limit_ini'] = 2017;
                    $filtro['limit_fim'] = 2020;
                break;
        }

        $section_show = request()->section ?? '';
        
        $json_lattes = LattesModel::where('codpes',$codpes)->first();
            
        $lattes = $json_lattes ? json_decode($json_lattes->json,TRUE) : null;
        //$lattes = Lattes::getArray($codpes); 

        $content['nome'] = Pessoa::dump($codpes)['nompes'];
        $content['resumo'] = Lattes::getResumoCV($codpes, 'pt', $lattes);
        $content['livros'] = Lattes::getLivrosPublicados($codpes, $lattes, $filtro['tipo'], $filtro['limit_ini'], $filtro['limit_fim']);
        $content['linhas_pesquisa'] = Lattes::getLinhasPesquisa($codpes, $lattes);
        $content['artigos'] = Lattes::getArtigos($codpes, $lattes, $filtro['tipo'], $filtro['limit_ini'], $filtro['limit_fim']);
        $content['capitulos'] = Lattes::getCapitulosLivros($codpes, $lattes, $filtro['tipo'], $filtro['limit_ini'], $filtro['limit_fim']);
        $content['orientandos'] = Posgraduacao::obterOrientandosAtivos($codpes);
        $content['orientandos_concluidos'] = Posgraduacao::obterOrientandosConcluidos($codpes);
    
        return view('programas.docente',[
            'content' => $content,
            'section_show' => $section_show,
            'filtro' => $filtro,
            'form_action' => "/programas/docente/$codpes"
        ]);
      }
}
