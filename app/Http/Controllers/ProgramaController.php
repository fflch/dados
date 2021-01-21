<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Uspdev\Replicado\Posgraduacao;
use Uspdev\Replicado\Lattes;
use Uspdev\Replicado\Pessoa;
use App\Utils\ReplicadoTemp;

class ProgramaController extends Controller
{
    public function index(){
        $programas = Posgraduacao::programas(8);
        return view('programas.index',[
            'programas' => $programas,
        ]);
    }

    public function show($codare) {
        $programa = Posgraduacao::programas(8, null, $codare)[0];
        
        $credenciados = ReplicadoTemp::credenciados($codare);
        
        for($i = 0; $i < count($credenciados); $i++){
            
            $lattes = Lattes::getArray($credenciados[$i]['codpes']); 

            $credenciados[$i]['id_lattes'] = Lattes::id($credenciados[$i]['codpes']);
            $data_atualizacao = Lattes::getUltimaAtualizacao($credenciados[$i]['codpes'], $lattes) ; 
            $credenciados[$i]['data_atualizacao'] = $data_atualizacao ? substr($data_atualizacao, 0,2) . '/' . substr($data_atualizacao,2,2) . '/' . substr($data_atualizacao,4,4) : '-';
            
            $credenciados[$i]['total_livros'] = Lattes::getLivrosPublicados($credenciados[$i]['codpes'], 4, 'ano', $lattes);
            $credenciados[$i]['total_livros'] = $credenciados[$i]['total_livros'] ? count($credenciados[$i]['total_livros']) : '0';
            
            $credenciados[$i]['total_artigos'] = Lattes::getArtigos($credenciados[$i]['codpes'],4, 'ano', $lattes);
            $credenciados[$i]['total_artigos'] = $credenciados[$i]['total_artigos'] ? count($credenciados[$i]['total_artigos']) : '0';
            
            $credenciados[$i]['total_capitulos'] = Lattes::getCapitulosLivros($credenciados[$i]['codpes'], 5, $lattes);
            $credenciados[$i]['total_capitulos'] = $credenciados[$i]['total_capitulos'] ? count($credenciados[$i]['total_capitulos']) : '0';
            
            
            $credenciados[$i]['orientandos'] = Posgraduacao::obterOrientandosAtivos($credenciados[$i]['codpes']);
            $credenciados[$i]['orientandos'] = $credenciados[$i]['orientandos'] ? count($credenciados[$i]['orientandos']) : '0';

            $credenciados[$i]['orientandos_concluidos'] = Posgraduacao::obterOrientandosConcluidos($credenciados[$i]['codpes']);
            $credenciados[$i]['orientandos_concluidos'] = $credenciados[$i]['orientandos_concluidos'] ? count($credenciados[$i]['orientandos_concluidos']) : '0';
            

        }
        
        usort($credenciados, function ($a, $b) {
            return $a['nompes'] > $b['nompes'];
        });
        return view('programas.show',[
            'credenciados' => $credenciados,
            'programa' => $programa
        ]);
    }

    public function docente($codpes, Request $request) {
        $section_show = request()->section ?? '';
        
        $lattes = Lattes::getArray($codpes); 

        $content['nome'] = Pessoa::dump($codpes)['nompes'];
        $content['resumo'] = Lattes::getResumoCV($codpes, 'pt', $lattes);
        $content['livros'] = Lattes::getLivrosPublicados($codpes, 4, 'ano', $lattes);
        $content['linhas_pesquisa'] = Lattes::getLinhasPesquisa($codpes, $lattes);
        $content['artigos'] = Lattes::getArtigos($codpes,4, 'ano', $lattes);
        $content['capitulos'] = Lattes::getCapitulosLivros($codpes, 5, $lattes);
        $content['orientandos'] = Posgraduacao::obterOrientandosAtivos($codpes);
        $content['orientandos_concluidos'] = Posgraduacao::obterOrientandosConcluidos($codpes);
    
        return view('programas.docente',[
            'content' => $content,
            'section_show' => $section_show
        ]);
      }
}
