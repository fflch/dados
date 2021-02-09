<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Uspdev\Replicado\Posgraduacao;
use Uspdev\Replicado\Lattes;
use Uspdev\Replicado\Pessoa;
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

    
    public function show($codare, Request $request) {
        $filtro = Programa::getFiltro($request);        
        $programa = Posgraduacao::programas(8, null, $codare)[0];
        $credenciados = Programa::show($codare, $filtro);
        
        return view('programas.show',[
            'credenciados' => $credenciados,
            'programa' => $programa,
            'filtro' => $filtro,
            'form_action' => "/programas/$codare"
        ]);
    }

    public function docente($codpes, Request $request) {
        $filtro = $this->getFiltro($request);

        $section_show = request()->section ?? '';
        
        $json_lattes = LattesModel::where('codpes',$codpes)->first();
            
        $lattes = $json_lattes ? json_decode($json_lattes->json,TRUE) : null;
        //$lattes = Lattes::getArray($codpes); 

        $content['nome'] = $lattes['nome'];
        $content['resumo'] = $lattes['resumo'];
        $content['linhas_pesquisa'] = $lattes['linhas_pesquisa'];
        $content['livros'] = $this->hasValue($lattes,'livros') ? $this->filtrar($lattes['livros'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
        $content['artigos'] = $this->hasValue($lattes,'artigos') ? $this->filtrar($lattes['artigos'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
        $content['capitulos'] = $this->hasValue($lattes,'capitulos') ? $this->filtrar($lattes['capitulos'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
        $content['jornal_revista'] = $this->hasValue($lattes,'jornal_revista') ? $this->filtrar($lattes['jornal_revista'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
        $content['outras_producoes_bibliograficas'] = $this->hasValue($lattes,'outras_producoes_bibliograficas') ? $this->filtrar($lattes['outras_producoes_bibliograficas'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
        $content['trabalhos_anais'] = $this->hasValue($lattes,'trabalhos_anais') ? $this->filtrar($lattes['trabalhos_anais'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
        $content['trabalhos_tecnicos'] = $this->hasValue($lattes,'trabalhos_tecnicos') ? $this->filtrar($lattes['trabalhos_tecnicos'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;



        $content['orientandos'] = Posgraduacao::obterOrientandosAtivos($codpes);
        $content['orientandos_concluidos'] = Posgraduacao::obterOrientandosConcluidos($codpes);

      

    
        return view('programas.docente',[
            'content' => $content,
            'section_show' => $section_show,
            'filtro' => $filtro,
            'form_action' => "/programas/docente/$codpes"
        ]);
      }


    public function getFiltro(Request $request){
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
        return $filtro;
    }

    private function filtrar($array, $campo_ano, $tipo, $limit_ini, $limit_fim){
        $result = [];
        $i = 0;
        foreach($array as $item){
            $i++;
            if($tipo == 'registros'){
                if($limit_ini != -1 && $i > $limit_ini) continue;  //-1 retorna tudo
            }else if($tipo == 'anual' && isset($item[$campo_ano])){
                if($limit_ini != -1 &&  (int)$item[$campo_ano] !=  $limit_ini ) continue; //se for diferente do ano determinado, pula para o próximo
            }else if($tipo == 'periodo' && isset($item[$campo_ano])){
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

    

      private function hasValue($arr, $val){
          if(isset($arr[$val])){
              if($arr[$val] != null && $arr[$val] != false ){
                  return true;
              }
          }
          return false;
      }
}
