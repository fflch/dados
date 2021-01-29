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

            $json_lattes = LattesModel::where('codpes',$credenciados[$i]['codpes'])->first();
            
            $lattes = $json_lattes ? json_decode($json_lattes->json,TRUE) : null;
           
            
            //$lattes = Lattes::getArray($credenciados[$i]['codpes']); 
            
            $credenciados[$i]['href'] = "/programas/docente/".$credenciados[$i]['codpes'];
            $credenciados[$i]['href'] .= "?tipo=".$filtro['tipo']."&ano=".$filtro['limit_ini']."&ano_ini=".$filtro['limit_ini']."&ano_fim=".$filtro['limit_fim'];

            $credenciados[$i]['id_lattes'] = $lattes['id_lattes'];

            $credenciados[$i]['data_atualizacao'] =  $lattes['data_atualizacao'];
            
            $credenciados[$i]['total_livros'] = $lattes['livros'] ? $this->filtrar($lattes['livros'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
            $credenciados[$i]['total_livros'] = $credenciados[$i]['total_livros'] ? count($credenciados[$i]['total_livros']): '0';
            
            $credenciados[$i]['total_artigos'] = $lattes['artigos'] ? $this->filtrar($lattes['artigos'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
            $credenciados[$i]['total_artigos'] = $credenciados[$i]['total_artigos'] ? count($credenciados[$i]['total_artigos']): '0';
            
            $credenciados[$i]['total_capitulos'] = $lattes['capitulos'] ? $this->filtrar($lattes['capitulos'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
            $credenciados[$i]['total_capitulos'] = $credenciados[$i]['total_capitulos'] ? count($credenciados[$i]['total_capitulos']): '0';
            
 

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

    private function filtrar($array, $campo_ano, $tipo, $limit_ini, $limit_fim){
        $result = [];
        $i = 0;
        foreach($array as $item){
            $i++;
            if($tipo == 'registros'){
                if($limit_ini != -1 && $i > $limit_ini) continue;  //-1 retorna tudo
            }else if($tipo == 'anual'){
                if($limit_ini != -1 &&  (int)$item[$campo_ano] !=  $limit_ini ) continue; //se for diferente do ano determinado, pula para o próximo
            }else if($tipo == 'periodo'){
                if($limit_ini != -1 && 
                    (
                        (int)$item[$campo_ano] < $limit_ini ||
                        (int)$item[$campo_ano] > $limit_fim 
                    )
                 ) continue;
            }
            array_push($result, $item);
        }
        
        return $result;
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

        $content['nome'] = $lattes['nome'];
        $content['resumo'] = $lattes['resumo'];
        $content['livros'] = $this->filtrar($lattes['livros'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']);
        $content['linhas_pesquisa'] = $lattes['linhas_pesquisa'];
        $content['artigos'] = $this->filtrar($lattes['artigos'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']);
        $content['capitulos'] = $this->filtrar($lattes['capitulos'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']);
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
