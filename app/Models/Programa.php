<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Uspdev\Replicado\Lattes;
use App\Models\Lattes as LattesModel;
use Uspdev\Replicado\Pessoa;
use App\Utils\Util;
use App\Utils\ReplicadoTemp;
class Programa extends Model
{

    public static function index(){
        $programas = [];
        $departamentos = [];
        
        foreach(Programa::all() as $programa){
            if($programa->codare == 0){
                $departamentos = json_decode($programa->json);
            }else{
                $programas[] = json_decode($programa->json);
            }
        }

        return [
            'programas' => $programas,
            'departamentos' => $departamentos
        ]; 
        
    }

    public static function listarPessoa($pessoas, $filtro, $api, $tipo_pessoa, $excel){
        $aux_pessoas = [];
        $idLattes_pessoas = isset($pessoas[0]['codpes']) ? array_column($pessoas, 'codpes') : $pessoas;//$pessoas pode ser um array com subarrays que contenham codpes, ou um array simples de codpes. Ex [['codpes'=> 00000], ...] ou [00000, ...]
        
        $idLattes_pessoas = array_filter($idLattes_pessoas, function($e) {
            return ($e !== null);
        });
        $idLattes_pessoas = implode(',',$idLattes_pessoas);
        $json_lattes = \DB::select("SELECT codpes, `json` FROM lattes WHERE id_lattes  IN ( $idLattes_pessoas )");

        foreach($json_lattes as $json){
            $pessoa = [];

            $lattes = $json->json ? json_decode($json->json,TRUE) : null;
            $pessoa['id_lattes'] = $lattes['id_lattes'] ?? '';

            $pessoa['nompes'] = $lattes['nome'] ?? Pessoa::nomeCompleto($json->codpes ?? '');


            if(!$api && !$excel){
                if($tipo_pessoa == 'docentes'){
                    $pessoa['href'] = "/programas/docente/".$pessoa['id_lattes'];
                } else if ($tipo_pessoa == 'discentes'){
                    $pessoa['href'] = "/programas/discente/".$pessoa['id_lattes'];
                }
                else {
                    $pessoa['href'] = "/programas/egresso/".$pessoa['id_lattes'];
                }
                $pessoa['href'] .= "?tipo=".$filtro['tipo']."&ano=".$filtro['limit_ini']."&ano_ini=".$filtro['limit_ini']."&ano_fim=".$filtro['limit_fim'];
            }



            $pessoa['data_atualizacao'] =  $lattes['data_atualizacao'] ?? '';

            if(!$api){
                $pessoa['total_livros'] = Programa::hasValue($lattes,'livros') ? Programa::filtrar($lattes['livros'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
                $pessoa['total_livros'] = $pessoa['total_livros'] ? count($pessoa['total_livros']): '0';

                $pessoa['total_artigos'] = Programa::hasValue($lattes,'artigos') ? Programa::filtrar($lattes['artigos'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
                $pessoa['total_artigos'] = $pessoa['total_artigos'] ? count($pessoa['total_artigos']): '0';

                $pessoa['total_capitulos'] = Programa::hasValue($lattes,'capitulos') ? Programa::filtrar($lattes['capitulos'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
                $pessoa['total_capitulos'] = $pessoa['total_capitulos'] ? count($pessoa['total_capitulos']): '0';

                $pessoa['total_jornal_revista'] = Programa::hasValue($lattes,'jornal_revista') ? Programa::filtrar($lattes['jornal_revista'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
                $pessoa['total_jornal_revista'] = $pessoa['total_jornal_revista'] ? count($pessoa['total_jornal_revista']): '0';


                $pessoa['total_outras_producoes_bibliograficas'] = Programa::hasValue($lattes,'outras_producoes_bibliograficas') ? Programa::filtrar($lattes['outras_producoes_bibliograficas'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
                $pessoa['total_outras_producoes_bibliograficas'] = $pessoa['total_outras_producoes_bibliograficas'] ? count($pessoa['total_outras_producoes_bibliograficas']): '0';


                $pessoa['total_trabalhos_anais'] = Programa::hasValue($lattes,'trabalhos_anais') ? Programa::filtrar($lattes['trabalhos_anais'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
                $pessoa['total_trabalhos_anais'] = $pessoa['total_trabalhos_anais'] ? count($pessoa['total_trabalhos_anais']): '0';

                $pessoa['total_trabalhos_tecnicos'] = Programa::hasValue($lattes,'trabalhos_tecnicos') ? Programa::filtrar($lattes['trabalhos_tecnicos'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
                $pessoa['total_trabalhos_tecnicos'] = $pessoa['total_trabalhos_tecnicos'] ? count($pessoa['total_trabalhos_tecnicos']): '0';

                if($tipo_pessoa == 'egressos'){
                    $pessoa['total_ultima_formacao'] = Programa::hasValue($lattes,'ultima_formacao') ? Programa::filtrar($lattes['ultima_formacao'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
                    $pessoa['total_ultima_formacao'] = $pessoa['total_ultima_formacao'] ? count($pessoa['total_ultima_formacao']): '0';

                    $pessoa['total_ultimo_vinculo_profissional'] = Programa::hasValue($lattes,'ultimo_vinculo_profissional') ? Programa::filtrar($lattes['ultimo_vinculo_profissional'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
                    $pessoa['total_ultimo_vinculo_profissional'] = $pessoa['total_ultimo_vinculo_profissional'] ? count($pessoa['total_ultimo_vinculo_profissional']): '0';
                }

                $pessoa['total_organizacao_evento'] = Programa::hasValue($lattes,'organizacao_evento') ? Programa::filtrar($lattes['organizacao_evento'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
                $pessoa['total_organizacao_evento'] = $pessoa['total_organizacao_evento'] ? count($pessoa['total_organizacao_evento']): '0';

                $pessoa['total_curso_curta_duracao'] = Programa::hasValue($lattes,'curso_curta_duracao') ? Programa::filtrar($lattes['curso_curta_duracao'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
                $pessoa['total_curso_curta_duracao'] = $pessoa['total_curso_curta_duracao'] ? count($pessoa['total_curso_curta_duracao']): '0';

                $pessoa['total_relatorio_pesquisa'] = Programa::hasValue($lattes,'relatorio_pesquisa') ? Programa::filtrar($lattes['relatorio_pesquisa'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
                $pessoa['total_relatorio_pesquisa'] = $pessoa['total_relatorio_pesquisa'] ? count($pessoa['total_relatorio_pesquisa']): '0';

                $pessoa['total_material_didatico'] = Programa::hasValue($lattes,'material_didatico') ? Programa::filtrar($lattes['material_didatico'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
                $pessoa['total_material_didatico'] = $pessoa['total_material_didatico'] ? count($pessoa['total_material_didatico']): '0';

                $pessoa['total_outras_producoes_tecnicas'] = Programa::hasValue($lattes,'outras_producoes_tecnicas') ? Programa::filtrar($lattes['outras_producoes_tecnicas'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
                $pessoa['total_outras_producoes_tecnicas'] = $pessoa['total_outras_producoes_tecnicas'] ? count($pessoa['total_outras_producoes_tecnicas']): '0';

                $pessoa['total_projetos_pesquisa'] = Programa::hasValue($lattes,'projetos_pesquisa') ? Programa::filtrar($lattes['projetos_pesquisa'], 'ANO-INICIO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
                $pessoa['total_projetos_pesquisa'] = $pessoa['total_projetos_pesquisa'] ? count($pessoa['total_projetos_pesquisa']): '0';

                $pessoa['total_apresentacao_trabalho'] = Programa::hasValue($lattes,'apresentacao_trabalho') ? Programa::filtrar($lattes['apresentacao_trabalho'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
                $pessoa['total_apresentacao_trabalho'] = $pessoa['total_apresentacao_trabalho'] ? count($pessoa['total_apresentacao_trabalho']): '0';

                $pessoa['total_radio_tv'] = Programa::hasValue($lattes,'radio_tv') ? Programa::filtrar($lattes['radio_tv'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
                $pessoa['total_radio_tv'] = $pessoa['total_radio_tv'] ? count($pessoa['total_radio_tv']): '0';

            }else{
                $pessoa['livros'] = Programa::hasValue($lattes,'livros') ? Programa::filtrar($lattes['livros'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
                $pessoa['artigos'] = Programa::hasValue($lattes,'artigos') ? Programa::filtrar($lattes['artigos'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
                $pessoa['capitulos'] = Programa::hasValue($lattes,'capitulos') ? Programa::filtrar($lattes['capitulos'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
                $pessoa['jornal_revista'] = Programa::hasValue($lattes,'jornal_revista') ? Programa::filtrar($lattes['jornal_revista'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
                $pessoa['outras_producoes_bibliograficas'] = Programa::hasValue($lattes,'outras_producoes_bibliograficas') ? Programa::filtrar($lattes['outras_producoes_bibliograficas'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
                $pessoa['trabalhos_anais'] = Programa::hasValue($lattes,'trabalhos_anais') ? Programa::filtrar($lattes['trabalhos_anais'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
                $pessoa['trabalhos_tecnicos'] = Programa::hasValue($lattes,'trabalhos_tecnicos') ? Programa::filtrar($lattes['trabalhos_tecnicos'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
                $pessoa['organizacao_evento'] = Programa::hasValue($lattes,'organizacao_evento') ? Programa::filtrar($lattes['organizacao_evento'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : false;
                $pessoa['trabalhos_tecnicos'] = Programa::hasValue($lattes,'trabalhos_tecnicos') ? Programa::filtrar($lattes['trabalhos_tecnicos'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
                $pessoa['organizacao_evento'] = Programa::hasValue($lattes,'organizacao_evento') ? Programa::filtrar($lattes['organizacao_evento'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
                $pessoa['outras_producoes_tecnicas'] = Programa::hasValue($lattes,'outras_producoes_tecnicas') ? Programa::filtrar($lattes['outras_producoes_tecnicas'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
                $pessoa['curso_curta_duracao'] = Programa::hasValue($lattes,'curso_curta_duracao') ? Programa::filtrar($lattes['curso_curta_duracao'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
                $pessoa['relatorio_pesquisa'] = Programa::hasValue($lattes,'relatorio_pesquisa') ? Programa::filtrar($lattes['relatorio_pesquisa'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
                $pessoa['material_didatico'] = Programa::hasValue($lattes,'material_didatico') ? Programa::filtrar($lattes['material_didatico'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
                $pessoa['projetos_pesquisa'] = Programa::hasValue($lattes,'projetos_pesquisa') ? Programa::filtrar($lattes['projetos_pesquisa'], 'ANO-INICIO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
                $pessoa['apresentacao_trabalho'] = Programa::hasValue($lattes,'apresentacao_trabalho') ? Programa::filtrar($lattes['apresentacao_trabalho'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
                $pessoa['radio_tv'] = Programa::hasValue($lattes,'radio_tv') ? Programa::filtrar($lattes['radio_tv'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;

            }

            if(isset($pessoa['nompes']) && $pessoa['nompes'] != ''){
                array_push($aux_pessoas, $pessoa);
            }

        }

        setlocale(LC_COLLATE, 'pt_BR.utf8'); //ordena corretamente os nomes com acentos

        usort($aux_pessoas, function ($a, $b) {
            return strcoll($a["nompes"], $b["nompes"]);
        });

        return $aux_pessoas;
    }

    public static function obterPessoa($codpes, $filtro, $api = false, $tipo_pessoa = 'docentes') {




        $json_lattes = LattesModel::where('codpes',$codpes)->first();

        $lattes = $json_lattes ? json_decode($json_lattes->json,TRUE) : null;
        if($lattes == null) return [];

        $content['id_lattes'] = $lattes['id_lattes'] ?? null;
        $content['orcid'] = $lattes['orcid'] ?? null;
        $content['nome'] = Pessoa::nomeCompleto($codpes);
        $content['resumo'] = $lattes['resumo'] ?? '';
        $content['linhas_pesquisa'] = $lattes['linhas_pesquisa'] ?? '';



        $aux_livros_destaques = Programa::hasValue($lattes,'livros') ? $lattes['livros'] : null; //Pega todos os livros (sem filtrar)
        /**
         * Busca os livros de destaque (especificados a partir da demanada do docente e através do ISBN) entre todos os livros do docente.
         * Os seguintes ISBNs '9788538709015', '9788577321162', '9788531413025' são livros do docente Paulo Martins
         */
        $destaques = $aux_livros_destaques != null ? Programa::definirDestaqueLivro($aux_livros_destaques, ['9788538709015', '9788577321162', '9788531413025']) : null;
        /**
         * Tira da exibição alguns livros sem relevância acadêmica (especificados a partir da demanada do docente e através do ISBN) entre todos os livros do docente.
         * Os seguintes ISBNs ['9788575063712', '9788575063279'] são livros do docente Paulo Martins
         */
        $remover_livros = ['9788575063712', '9788575063279'];
        /*
            Inclusão dos livros em destaque para serem removidos da lista de livros filtrados, pois estes livros destacados serão exibidos independentemente do filtro.
        */

        if(is_array($destaques)){
            foreach($destaques as $d){
                if(isset($d['ISBN']) && !empty($d['ISBN']) && $d['ISBN'] != null){
                    $remover_livros[] = $d['ISBN'];
                }
            }
        }
        $livros = Programa::hasValue($lattes,'livros') ? Programa::filtrar($lattes['livros'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
        $livros = is_array($livros) && count($livros) > 0 ? Programa::removerLivros($livros, $remover_livros) : null;
        /*
            Inclusão dos livros em destaque no começo da lista de livros
         */

        if(is_array($destaques) && is_array($livros)){
            foreach($destaques as $d){
                array_unshift($livros, $d); //coloca o elemento na primeira posição do array
            }
        }
        $content['livros'] = $livros ?? null;

        $content['artigos'] = Programa::hasValue($lattes,'artigos') ? Programa::filtrar($lattes['artigos'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
        $content['capitulos'] = Programa::hasValue($lattes,'capitulos') ? Programa::filtrar($lattes['capitulos'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
        $content['jornal_revista'] = Programa::hasValue($lattes,'jornal_revista') ? Programa::filtrar($lattes['jornal_revista'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
        $content['outras_producoes_bibliograficas'] = Programa::hasValue($lattes,'outras_producoes_bibliograficas') ? Programa::filtrar($lattes['outras_producoes_bibliograficas'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
        $content['trabalhos_anais'] = Programa::hasValue($lattes,'trabalhos_anais') ? Programa::filtrar($lattes['trabalhos_anais'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
        $content['trabalhos_tecnicos'] = Programa::hasValue($lattes,'trabalhos_tecnicos') ? Programa::filtrar($lattes['trabalhos_tecnicos'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
        $content['trabalhos_tecnicos'] = Programa::hasValue($lattes,'trabalhos_tecnicos') ? Programa::filtrar($lattes['trabalhos_tecnicos'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
        $content['organizacao_evento'] = Programa::hasValue($lattes,'organizacao_evento') ? Programa::filtrar($lattes['organizacao_evento'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
        $content['outras_producoes_tecnicas'] = Programa::hasValue($lattes,'outras_producoes_tecnicas') ? Programa::filtrar($lattes['outras_producoes_tecnicas'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
        $content['curso_curta_duracao'] = Programa::hasValue($lattes,'curso_curta_duracao') ? Programa::filtrar($lattes['curso_curta_duracao'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
        $content['relatorio_pesquisa'] = Programa::hasValue($lattes,'relatorio_pesquisa') ? Programa::filtrar($lattes['relatorio_pesquisa'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
        $content['material_didatico'] = Programa::hasValue($lattes,'material_didatico') ? Programa::filtrar($lattes['material_didatico'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
        $content['projetos_pesquisa'] = Programa::hasValue($lattes,'projetos_pesquisa') ? Programa::filtrar($lattes['projetos_pesquisa'], 'ANO-INICIO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
        $content['apresentacao_trabalho'] = Programa::hasValue($lattes,'apresentacao_trabalho') ? Programa::filtrar($lattes['apresentacao_trabalho'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
        $content['radio_tv'] = Programa::hasValue($lattes,'radio_tv') ? Programa::filtrar($lattes['radio_tv'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;



        if($tipo_pessoa == 'docentes'){
            $content['orientandos'] = Programa::hasValue($lattes,'orientandos') ? $lattes['orientandos'] : null;
            $content['orientandos_concluidos'] = Programa::hasValue($lattes,'orientandos_concluidos') ? $lattes['orientandos_concluidos'] : null;
        }

        if($tipo_pessoa == 'egressos'){
            $content['ultima_formacao'] = Programa::hasValue($lattes,'ultima_formacao') ? $lattes['ultima_formacao'] : null;
            $content['ultimo_vinculo_profissional'] = Programa::hasValue($lattes,'ultimo_vinculo_profissional') ? Programa::filtrar($lattes['ultimo_vinculo_profissional'], 'ANO',$filtro['tipo'], $filtro['limit_ini'],$filtro['limit_fim']) : null;
        }


        return $content;
    }

    public static function obterOrcid(){
        $orcid = [];
        $pessoas = LattesModel::where('codpes', '<>', null)->get()->toArray();
        foreach($pessoas as $pessoa){
            $lattes = $pessoa ? json_decode($pessoa['json'],TRUE) : null;
            if(isset($lattes['orcid']) && $lattes['orcid'] != false && $lattes['orcid'] != ""){
                $aux = [
                    'id_lattes' => $lattes['id_lattes'],
                    'nompes' => $lattes['nome'],
                    'orcid' => $lattes['orcid'],
                ];
                array_push($orcid, $aux);
            }
        }
        return $orcid;
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
            default:
                $filtro['tipo'] = 'tudo';
                $filtro['limit_ini'] = null;
                    $filtro['limit_fim'] = null;
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


    private static function removerLivros($livros, $isbn){
        foreach($livros as $key=>$value){
            if(in_array($value['ISBN'], $isbn)){
                    unset($livros[$key]);
            }
        }
        return $livros;
    }

    private static function definirDestaqueLivro($livros, $isbn){
        $destaques = [];
        foreach($livros as $key=>$value){
            if(in_array($value['ISBN'], $isbn)){
                $destaque = $livros[$key];
                $destaque['destaque'] = true;
                unset($livros[$key]);
                array_push($destaques, $destaque);
            }
        }

        return $destaques;
    }
}
