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
        # Mostrar nome do programa
        
        $credenciados = ReplicadoTemp::credenciados($codare);
        for($i = 0; $i < count($credenciados); $i++){
            $lattes = Lattes::getArray($credenciados[$i]['codpes']); 
            $credenciados[$i]['id_lattes'] = Lattes::id($credenciados[$i]['codpes']);
            $data_atualizacao = Lattes::getUltimaAtualizacao($credenciados[$i]['codpes'], $lattes) ; 
            
            $credenciados[$i]['data_atualizacao'] = $data_atualizacao ? substr($data_atualizacao, 0,2) . '/' . substr($data_atualizacao,2,2) . '/' . substr($data_atualizacao,4,4) : '-';

        }
        usort($credenciados, function ($a, $b) {
            return $a['nompes'] > $b['nompes'];
        });
        return view('programas.show',[
            'credenciados' => $credenciados,
        ]);
    }

    public function docente($codpes) {
        $lattes = Lattes::getArray($codpes); 

        $content['nome'] = Pessoa::dump($codpes)['nompes'];
        $content['resumo'] = Lattes::getResumoCV($codpes, 'pt', $lattes);
        $content['livros'] = Lattes::getLivrosPublicados($codpes, 4, 'ano', $lattes);
        $content['linhas_pesquisa'] = Lattes::getLinhasPesquisa($codpes, $lattes);
        $content['artigos'] = Lattes::getArtigos($codpes,4, 'ano', $lattes);
        $content['capitulos'] = Lattes::getCapitulosLivros($codpes, 5, $lattes);
        //$content['orientandos'] = Posgraduacao::obterOrientandosAtivos($codpes);
        //dd($content['resumo']);
    
        return view('programas.docente',[
            'content' => $content,
        ]);
      }
}
