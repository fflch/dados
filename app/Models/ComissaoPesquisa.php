<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request; 
use Uspdev\Replicado\Posgraduacao;
use Uspdev\Replicado\Pessoa;
use App\Utils\ReplicadoTemp;
use App\Models\Lattes as LattesModel;
use App\Models\Programa;
use App\Utils\Util;



class ComissaoPesquisa extends Model
{
    use HasFactory;


    public static function contarPesquisasAtivasPorTipo(Request $request){ 
        $data = [];

        if($request->filtro == 'departamento'){
            
       
            foreach(Util::getDepartamentos() as $key=>$dep){
                $data[$key] = [];
                $data[$key]['nome_departamento'] = $dep[1];
                
                $data[$key]['ic_com_bolsa'] = ComissaoPesquisa::where('sigla_departamento',$key)->where('bolsa', 'true')->where('tipo', 'IC')->get()->count();
                $data[$key]['ic_sem_bolsa'] = ComissaoPesquisa::where('sigla_departamento',$key)->where('bolsa', 'false')->where('tipo', 'IC')->get()->count();
                
                $data[$key]['pesquisadores_colab'] = ComissaoPesquisa::where('sigla_departamento',$key)->where('tipo', 'PC')->get()->count();
                
                $data[$key]['projetos_pesquisa'] = ComissaoPesquisa::where('sigla_departamento',$key)->where('tipo', 'PP')->get()->count();
                
                $data[$key]['pesquisas_pos_doutorado_com_bolsa'] = ComissaoPesquisa::where('sigla_departamento',$key)->where('bolsa', 'true')->where('tipo', 'PD')->get()->count();
                $data[$key]['pesquisas_pos_doutorado_sem_bolsa'] = ComissaoPesquisa::where('sigla_departamento',$key)->where('bolsa', 'false')->where('tipo', 'PD')->get()->count();
            
            }
        }else if($request->filtro  == 'serie_historica' && isset($request->ano_ini) && isset($request->ano_fim)){
            
            $ano_ini = (int)$request->ano_ini ?? date('Y');
            $ano_fim = (int)$request->ano_fim ?? date('Y');
            $data_tipo = $request->serie_historica_tipo;
            if($data_tipo == 'curso'){
                foreach(Util::getCursos() as $key=>$cur){
                    $data[$cur] = [];
                    for($ano = $ano_ini; $ano <= $ano_fim; $ano++){
                        $data[$cur][$ano] = [];
                        $data[$cur][$ano]['ic_com_bolsa'] = ComissaoPesquisa::where(function ($query) use ($ano) {
                            $query->where('ano_proj', '=', $ano);
                        })->where('bolsa', 'true')->where('tipo', 'IC')->where('cod_curso',$key)->get()->count();
        
                        $data[$cur][$ano]['ic_sem_bolsa'] = 
                        ComissaoPesquisa::where(function ($query) use ($ano) {
                            $query->where('ano_proj', '=', $ano);
                        })->where('bolsa', 'false')->where('tipo', 'IC')->where('cod_curso',$key)->get()->count();
        
                        $data[$cur][$ano]['pesquisadores_colab'] = ComissaoPesquisa::where(function ($query) use ($ano) {
                            $query->whereYear('data_ini', '=', $ano)
                                ->orWhere('ano_proj', '=', $ano);
                        })->where('tipo', 'PC')->where('cod_curso',$key)->get()->count();
                                        
                        $data[$cur][$ano]['projetos_pesquisa'] = ComissaoPesquisa::where(function ($query) use ($ano) {
                            $query->whereYear('data_ini', '=', $ano)
                                ->orWhere('ano_proj', '=', $ano);
                        })->where('tipo', 'PP')->where('cod_curso',$key)->get()->count();
                        
                        $data[$cur][$ano]['pesquisas_pos_doutorado_com_bolsa'] = ComissaoPesquisa::where(function ($query) use ($ano) {
                            $query->whereYear('data_ini', '=', $ano)
                                ->orWhere('ano_proj', '=', $ano);
                        })->where('bolsa', 'true')->where('tipo', 'PD')->where('cod_curso',$key)->get()->count();
                        
                        $data[$cur][$ano]['pesquisas_pos_doutorado_sem_bolsa'] = ComissaoPesquisa::where(function ($query) use ($ano) {
                            $query->whereYear('data_ini', '=', $ano)
                                ->orWhere('ano_proj', '=', $ano);
                        })->where('bolsa', 'false')->where('tipo', 'PD')->where('cod_curso',$key)->get()->count();
                    }
                
                }
                
            }else {
                foreach(Util::getDepartamentos() as $key=>$dep){
                    $data[$dep[1]] = [];
                    for($ano = $ano_ini; $ano <= $ano_fim; $ano++){
                        $data[$dep[1]][$ano] = [];
                        $data[$dep[1]][$ano]['ic_com_bolsa'] = ComissaoPesquisa::where(function ($query) use ($ano) {
                            $query->where('ano_proj', '=', $ano);
                        })->where('bolsa', 'true')->where('tipo', 'IC')->where('sigla_departamento',$key)->get()->count();
        
                        $data[$dep[1]][$ano]['ic_sem_bolsa'] = 
                        ComissaoPesquisa::where(function ($query) use ($ano) {
                            $query->where('ano_proj', '=', $ano);
                        })->where('bolsa', 'false')->where('tipo', 'IC')->where('sigla_departamento',$key)->get()->count();
        
                        $data[$dep[1]][$ano]['pesquisadores_colab'] = ComissaoPesquisa::where(function ($query) use ($ano) {
                            $query->whereYear('data_ini', '=', $ano)
                                ->orWhere('ano_proj', '=', $ano);
                        })->where('tipo', 'PC')->where('sigla_departamento',$key)->get()->count();
                                        
                        $data[$dep[1]][$ano]['projetos_pesquisa'] = ComissaoPesquisa::where(function ($query) use ($ano) {
                            $query->whereYear('data_ini', '=', $ano)
                                ->orWhere('ano_proj', '=', $ano);
                        })->where('tipo', 'PP')->where('sigla_departamento',$key)->get()->count();
                        
                        $data[$dep[1]][$ano]['pesquisas_pos_doutorado_com_bolsa'] = ComissaoPesquisa::where(function ($query) use ($ano) {
                            $query->whereYear('data_ini', '=', $ano)
                                ->orWhere('ano_proj', '=', $ano);
                        })->where('bolsa', 'true')->where('tipo', 'PD')->where('sigla_departamento',$key)->get()->count();
                        
                        $data[$dep[1]][$ano]['pesquisas_pos_doutorado_sem_bolsa'] = ComissaoPesquisa::where(function ($query) use ($ano) {
                            $query->whereYear('data_ini', '=', $ano)
                                ->orWhere('ano_proj', '=', $ano);
                        })->where('bolsa', 'false')->where('tipo', 'PD')->where('sigla_departamento',$key)->get()->count();
                    }
                
                }
            }
            
    
        }else{ //cursos (default)
            foreach(Util::getCursos() as $key=>$c){
                $data[$key] = [];
                $data[$key]['nome_curso'] = $c;
                
                $data[$key]['ic_com_bolsa'] = ComissaoPesquisa::where('cod_curso',$key)->where('bolsa', 'true')->where('tipo', 'IC')->get()->count();
                $data[$key]['ic_sem_bolsa'] = ComissaoPesquisa::where('cod_curso',$key)->where('bolsa', 'false')->where('tipo', 'IC')->get()->count();

                $data[$key]['pesquisadores_colab'] = ComissaoPesquisa::where('cod_curso',$key)->where('tipo', 'PC')->get()->count();
                
                $data[$key]['projetos_pesquisa'] = ComissaoPesquisa::where('cod_curso',$key)->where('tipo', 'PP')->get()->count();

                $data[$key]['pesquisas_pos_doutorado_com_bolsa'] = ComissaoPesquisa::where('cod_curso',$key)->where('bolsa', 'true')->where('tipo', 'PD')->get()->count();
                $data[$key]['pesquisas_pos_doutorado_sem_bolsa'] = ComissaoPesquisa::where('cod_curso',$key)->where('bolsa', 'false')->where('tipo', 'PD')->get()->count();
            
            
            }
        }
        

      
        return $data;
    }

    public static function listarIniciacaoCientifica(Request $request, bool $isAuthenticated  = false){

        $tipo = $request->tipo ?? 'tudo';
        $bolsa = $request->bolsa == 'true' ? 'true' : 'false';
        $limit_fim = null; 
        if($tipo == 'anual'){
            $limit_ini = $request->ano ?? date('Y');
        }else if ($tipo  == 'ativo'){
            $limit_ini = date('Y');
        }else if($tipo == 'periodo'){
            $limit_ini = $request->ano_ini ?? date('Y');
            $limit_fim = $request->ano_fim ?? date('Y');
        }

        if(isset($request->departamento)){
            $key_filtro = 'sigla_departamento';
            $value_filtro = $request->departamento;            
        }else{
            $key_filtro = 'cod_curso';
            $value_filtro = $request->curso;
        }


        if($tipo == 'anual'){
            $iniciacao_cientifica = 
                ComissaoPesquisa::where(function ($query) use ($key_filtro, $value_filtro, $bolsa, $limit_ini) {
                    return $query->where($key_filtro,$value_filtro)
                    ->where('bolsa', '=', $bolsa)
                    ->where('tipo', '=', 'IC')
                    ->where('ano_proj', $limit_ini);
                })->get()->toArray();
                //dd($iniciacao_cientifica);
        }else if ($tipo  == 'ativo'){
            $iniciacao_cientifica = 
                ComissaoPesquisa::where(function ($query) use ($key_filtro, $value_filtro, $bolsa) {
                    return $query->where($key_filtro,$value_filtro)
                    ->where('bolsa', '=', $bolsa)
                    ->where('tipo', '=', 'IC');
                })->where(function ($query) use ($limit_ini) {
                    return $query->whereYear('data_fim', '=', $limit_ini)
                        ->orWhereYear('data_fim', '>', $limit_ini)
                        ->orWhereYear('data_fim', '=', null);
                })->where(function ($query){
                    return $query->where('status_projeto', '=', 'Ativo')
                    ->orWhere('status_projeto', '=', 'Inscrito')
                    ->orWhere('status_projeto', '=', 'Inscrito PIBI');
                })->get()->toArray();
        }else if($tipo == 'periodo'){
            $iniciacao_cientifica = 
                ComissaoPesquisa::where(function ($query) use ($key_filtro, $value_filtro, $bolsa) {
                    return $query->where($key_filtro,$value_filtro)
                    ->where('bolsa', '=', $bolsa)
                    ->where('tipo', '=', 'IC');
                })->where(function ($query) use ($limit_ini, $limit_fim) {
                    return $query->whereBetween('data_ini', ["$limit_ini-01-01", "$limit_fim-12-31"])
                        ->orWhereBetween('data_fim', ["$limit_ini-01-01", "$limit_fim-12-31"])
                        ->orWhereBetween('ano_proj', ["$limit_ini-01-01", "$limit_fim-12-31"]);
                })->get()->toArray();
        }else if($tipo == 'tudo'){
            $iniciacao_cientifica = 
                ComissaoPesquisa::where(function ($query) use ($key_filtro, $value_filtro, $bolsa) {
                    return $query->where($key_filtro,$value_filtro)
                    ->where('bolsa', '=', $bolsa)
                    ->where('tipo', '=', 'IC');
                })->get()->toArray();
        }

        if($iniciacao_cientifica){
            $retorno = [];
            foreach($iniciacao_cientifica as $ic){
                $aux = [
                        "id" => $ic["id"],
                        "codproj" => $ic["codproj"],
                        "nome_discente" => $ic["nome_discente"],
                        "genero_discente" => $ic["genero_discente"],
                        "raca_cor_discente" => $ic["raca_cor_discente"],
                        "nome_supervisor" => $ic["nome_supervisor"],
                        "genero_supervisor" => $ic["genero_supervisor"],
                        "titulo_pesquisa" => $ic["titulo_pesquisa"],
                        "data_ini" => $ic["data_ini"],
                        "data_fim" => $ic["data_fim"],
                        "ano_proj" => $ic["ano_proj"],
                        "bolsa" => $ic["bolsa"],
                        "dtainibol" => $ic["dtainibol"],
                        "dtafimbol" => $ic["dtafimbol"],
                        "sigla_departamento" => $ic["sigla_departamento"],
                        "nome_departamento" => $ic["nome_departamento"],
                        "cod_curso" => $ic["cod_curso"],
                        "nome_curso" => $ic["nome_curso"],
                        "status_projeto" => $ic["status_projeto"],
                       ];
                       
                if($isAuthenticated){
                    $aux['codpes_discente'] = $ic['codpes_discente'];
                    $aux['codpes_supervisor'] = $ic['codpes_supervisor'];          
                }
                 array_push($retorno, $aux);
            }
            return $retorno;
        }else{
            return null;
        }
   
        return $iniciacao_cientifica ?? null;  
    }

    public static function listarPesquisasPosDoutorandos(Request $request){
        $bolsa = $request->bolsa == 'true' ? 'true' : 'false';
        if(isset($request->departamento)){
            $pd = ComissaoPesquisa::where('sigla_departamento',$request->departamento)->where('bolsa', $bolsa)->where('tipo', 'PD')->get()->toArray();
        }else{
            $pd = ComissaoPesquisa::where('cod_curso',$request->curso)->where('bolsa', $bolsa)->where('tipo', 'PD')->get()->toArray();
        }

        $retorno = [];
        if($pd){
            foreach($pd as $p){
                $aux = [
                        "id" => $p["id"],
                        "codproj" => $p["codproj"],
                        "nome_discente" => $p["nome_discente"],
                        "nome_supervisor" => $p["nome_supervisor"],
                        "titulo_pesquisa" => $p["titulo_pesquisa"],
                        "data_ini" => $p["data_ini"],
                        "data_fim" => $p["data_fim"],
                        "bolsa" => $p["bolsa"],
                        "sigla_departamento" => $p["sigla_departamento"],
                        "nome_departamento" => $p["nome_departamento"],
                        "cod_curso" => $p["cod_curso"],
                        "nome_curso" => $p["nome_curso"],
                ];
                array_push($retorno, $aux);
            }
            return $retorno;
        }else{
            return null;
        }
    }

    public static function listarProjetosPesquisa(Request $request){
        if(isset($request->departamento)){
            $projetos_pesquisa = ComissaoPesquisa::where('sigla_departamento',$request->departamento)->where('tipo', 'PP')->get()->toArray();
        }else{
            $projetos_pesquisa = ComissaoPesquisa::where('cod_curso',$request->curso)->where('tipo', 'PP')->get()->toArray();
        }

        $retorno = [];
        if($projetos_pesquisa){
            foreach($projetos_pesquisa as $projeto){
                $aux = [
                        "id" => $projeto["id"],
                        "nome_discente" => $projeto["nome_discente"],
                        "titulo_pesquisa" => $projeto["titulo_pesquisa"],
                        "data_ini" => $projeto["data_ini"],
                        "data_fim" => $projeto["data_fim"],
                        "sigla_departamento" => $projeto["sigla_departamento"],
                        "nome_departamento" => $projeto["nome_departamento"],
                        "cod_curso" => $projeto["cod_curso"],
                        "nome_curso" => $projeto["nome_curso"],
                ];
                array_push($retorno, $aux);
            }
            return $retorno;
        }else{
            return null;
        }
     
    }

    public static function listarPesquisadoresColaboradores(Request $request){
        if(isset($request->departamento)){
            $pesquisadores_colab = ComissaoPesquisa::where('sigla_departamento',$request->departamento)->where('tipo', 'PC')->get()->toArray();
        }else{
            $pesquisadores_colab = ComissaoPesquisa::where('cod_curso',$request->curso)->where('tipo', 'PC')->get()->toArray();
        }
        $retorno = [];
        if($pesquisadores_colab){
            foreach($pesquisadores_colab as $pesquisador){
                $aux = [
                        "id" => $pesquisador["id"],
                        "codproj" => $pesquisador["codproj"],
                        "nome_discente" => $pesquisador["nome_discente"],
                        "nome_supervisor" => $pesquisador["nome_supervisor"],
                        "titulo_pesquisa" => $pesquisador["titulo_pesquisa"],
                        "data_ini" => $pesquisador["data_ini"],
                        "data_fim" => $pesquisador["data_fim"],
                        "sigla_departamento" => $pesquisador["sigla_departamento"],
                        "nome_departamento" => $pesquisador["nome_departamento"],
                        "cod_curso" => $pesquisador["cod_curso"],
                        "nome_curso" => $pesquisador["nome_curso"],
                ];
                array_push($retorno, $aux);
            }
            return $retorno;
        }else{
            return null;
        }
    }
}
