<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Uspdev\Replicado\Posgraduacao;
use Illuminate\Http\Request;
use Uspdev\Replicado\Lattes;
use App\Utils\ReplicadoTemp;
use App\Models\Lattes as LattesModel;

class Programa extends Model
{

    public static function index(){
        $programas = [];
        foreach(Programa::all() as $programa){
            $aux_programa = json_decode($programa->json);
            $total_egresso = 0;
            if($aux_programa->egressos){
                foreach($aux_programa->egressos as $qtd_egresso)
                
                    $total_egresso += $qtd_egresso;
            }
            $aux_programa->total_egressos = $total_egresso;
            $programas[] = $aux_programa;
        }
        return $programas;
    }

    public static function listarPessoa($codare, $filtro, $pessoas, $api = false, $tipo_pessoa){
        $aux_pessoas = [];
        for($i = 0; $i < count($pessoas); $i++){

            $json_lattes = LattesModel::where('codpes',$pessoas[$i]['codpes'])->first();
            
            $lattes = $json_lattes ? json_decode($json_lattes->json,TRUE) : null; 

            if(!$api){
                if($tipo_pessoa == 'docente'){
                    $pessoas[$i]['href'] = "/programas/docente/".$pessoas[$i]['codpes'];
                } else if ($tipo_pessoa == 'discente'){
                    $pessoas[$i]['href'] = "/programas/discente/".$pessoas[$i]['codpes'];
                }
                else {
                    $pessoas[$i]['href'] = "/programas/egresso/".$pessoas[$i]['codpes'];
                }
                $pessoas[$i]['href'] .= "?tipo=".$filtro['tipo']."&ano=".$filtro['limit_ini']."&ano_ini=".$filtro['limit_ini']."&ano_fim=".$filtro['limit_fim'];
            }

            $pessoas[$i]['id_lattes'] = $lattes['id_lattes'] ?? '';

            $pessoas[$i]['data_atualizacao'] =  $lattes['data_atualizacao'] ?? '';
            if($tipo_pessoa == 'egresso'){
                $pessoas[$i]['ultima_formacao'] = Programa::hasValue($lattes,'ultima_formacao') ? $lattes['ultima_formacao'] : '';            
                $pessoas[$i]['ultimo_vinculo_profissional'] = Programa::hasValue($lattes,'ultimo_vinculo_profissional') ? $lattes['ultimo_vinculo_profissional'] : '';
            }
            
            if(!$api){
                $pessoas[$i]['total_livros'] = Programa::hasValue($lattes,'livros') ? Programa::filtrar($lattes['livros'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
                $pessoas[$i]['total_livros'] = $pessoas[$i]['total_livros'] ? count($pessoas[$i]['total_livros']): '0';
                
                $pessoas[$i]['total_artigos'] = Programa::hasValue($lattes,'artigos') ? Programa::filtrar($lattes['artigos'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
                $pessoas[$i]['total_artigos'] = $pessoas[$i]['total_artigos'] ? count($pessoas[$i]['total_artigos']): '0';
                
                $pessoas[$i]['total_capitulos'] = Programa::hasValue($lattes,'capitulos') ? Programa::filtrar($lattes['capitulos'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
                $pessoas[$i]['total_capitulos'] = $pessoas[$i]['total_capitulos'] ? count($pessoas[$i]['total_capitulos']): '0';
                
                $pessoas[$i]['total_jornal_revista'] = Programa::hasValue($lattes,'jornal_revista') ? Programa::filtrar($lattes['jornal_revista'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
                $pessoas[$i]['total_jornal_revista'] = $pessoas[$i]['total_jornal_revista'] ? count($pessoas[$i]['total_jornal_revista']): '0';
                
              
                $pessoas[$i]['total_outras_producoes_bibliograficas'] = Programa::hasValue($lattes,'outras_producoes_bibliograficas') ? Programa::filtrar($lattes['outras_producoes_bibliograficas'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
                $pessoas[$i]['total_outras_producoes_bibliograficas'] = $pessoas[$i]['total_outras_producoes_bibliograficas'] ? count($pessoas[$i]['total_outras_producoes_bibliograficas']): '0';
    
    
                $pessoas[$i]['total_trabalhos_anais'] = Programa::hasValue($lattes,'trabalhos_anais') ? Programa::filtrar($lattes['trabalhos_anais'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
                $pessoas[$i]['total_trabalhos_anais'] = $pessoas[$i]['total_trabalhos_anais'] ? count($pessoas[$i]['total_trabalhos_anais']): '0';
    
                $pessoas[$i]['total_trabalhos_tecnicos'] = Programa::hasValue($lattes,'trabalhos_tecnicos') ? Programa::filtrar($lattes['trabalhos_tecnicos'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
                $pessoas[$i]['total_trabalhos_tecnicos'] = $pessoas[$i]['total_trabalhos_tecnicos'] ? count($pessoas[$i]['total_trabalhos_tecnicos']): '0';

                $pessoas[$i]['total_ultima_formacao'] = Programa::hasValue($lattes,'ultima_formacao') ? Programa::filtrar($lattes['ultima_formacao'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
                $pessoas[$i]['total_ultima_formacao'] = $pessoas[$i]['total_ultima_formacao'] ? count($pessoas[$i]['total_ultima_formacao']): '0';

                $pessoas[$i]['total_ultimo_vinculo_profissional'] = Programa::hasValue($lattes,'ultimo_vinculo_profissional') ? Programa::filtrar($lattes['ultimo_vinculo_profissional'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
                $pessoas[$i]['total_ultimo_vinculo_profissional'] = $pessoas[$i]['total_ultimo_vinculo_profissional'] ? count($pessoas[$i]['total_ultimo_vinculo_profissional']): '0';

            }else{
                $pessoas[$i]['livros'] = Programa::hasValue($lattes,'livros') ? Programa::filtrar($lattes['livros'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
                $pessoas[$i]['artigos'] = Programa::hasValue($lattes,'artigos') ? Programa::filtrar($lattes['artigos'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
                $pessoas[$i]['capitulos'] = Programa::hasValue($lattes,'capitulos') ? Programa::filtrar($lattes['capitulos'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
                $pessoas[$i]['jornal_revista'] = Programa::hasValue($lattes,'jornal_revista') ? Programa::filtrar($lattes['jornal_revista'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
                $pessoas[$i]['outras_producoes_bibliograficas'] = Programa::hasValue($lattes,'outras_producoes_bibliograficas') ? Programa::filtrar($lattes['outras_producoes_bibliograficas'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
                $pessoas[$i]['trabalhos_anais'] = Programa::hasValue($lattes,'trabalhos_anais') ? Programa::filtrar($lattes['trabalhos_anais'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
                $pessoas[$i]['trabalhos_tecnicos'] = Programa::hasValue($lattes,'trabalhos_tecnicos') ? Programa::filtrar($lattes['trabalhos_tecnicos'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
                $pessoas[$i]['organizacao_evento'] = Programa::hasValue($lattes,'organizacao_evento') ? Programa::filtrar($lattes['organizacao_evento'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
                
            }
            array_push($aux_pessoas, $pessoas[$i]);

        }
        usort($aux_pessoas, function ($a, $b) {
            return $a['nompes'] > $b['nompes'];
        });
        return $aux_pessoas;
    }

    public static function obterPessoa($codpes, $filtro, $api = false, $tipo_pessoa) {
        $json_lattes = LattesModel::where('codpes',$codpes)->first();
            
        $lattes = $json_lattes ? json_decode($json_lattes->json,TRUE) : null;

        $content['nome'] = $lattes['nome'];
        $content['resumo'] = $lattes['resumo'];
        $content['linhas_pesquisa'] = $lattes['linhas_pesquisa'];
        $content['livros'] = Programa::hasValue($lattes,'livros') ? Programa::filtrar($lattes['livros'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
        $content['artigos'] = Programa::hasValue($lattes,'artigos') ? Programa::filtrar($lattes['artigos'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
        $content['capitulos'] = Programa::hasValue($lattes,'capitulos') ? Programa::filtrar($lattes['capitulos'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
        $content['jornal_revista'] = Programa::hasValue($lattes,'jornal_revista') ? Programa::filtrar($lattes['jornal_revista'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
        $content['outras_producoes_bibliograficas'] = Programa::hasValue($lattes,'outras_producoes_bibliograficas') ? Programa::filtrar($lattes['outras_producoes_bibliograficas'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
        $content['trabalhos_anais'] = Programa::hasValue($lattes,'trabalhos_anais') ? Programa::filtrar($lattes['trabalhos_anais'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
        $content['trabalhos_tecnicos'] = Programa::hasValue($lattes,'trabalhos_tecnicos') ? Programa::filtrar($lattes['trabalhos_tecnicos'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
        
        if($tipo_pessoa == 'docente'){
            $content['orientandos'] = Posgraduacao::obterOrientandosAtivos($codpes);
            $content['orientandos_concluidos'] = Posgraduacao::obterOrientandosConcluidos($codpes);
        }

        if($tipo_pessoa == 'egresso'){
            $content['ultima_formacao'] = Programa::hasValue($lattes,'ultima_formacao') ? $lattes['ultima_formacao'] : null;
            $content['ultimo_vinculo_profissional'] = Programa::hasValue($lattes,'ultimo_vinculo_profissional') ? Programa::filtrar($lattes['ultimo_vinculo_profissional'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
        }
        return $content;
    }

    public static function getFiltro(Request $request){
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

    private static function filtrar($array, $campo_ano, $tipo, $limit_ini, $limit_fim){
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

    private static function hasValue($arr, $val){
        if(isset($arr[$val])){
            if($arr[$val] != null && $arr[$val] != false ){
                return true;
            }
        }
        return false;
    }

}
