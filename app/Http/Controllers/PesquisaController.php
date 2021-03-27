<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Uspdev\Replicado\Posgraduacao;
use Uspdev\Replicado\Pessoa;
use App\Utils\ReplicadoTemp;
use App\Models\Lattes as LattesModel;
use App\Models\Programa;
use App\Utils\Util;
use App\Models\ComissaoPesquisa;

class PesquisaController extends Controller
{
    

    public function index(Request $request){
        $departamentos = [];
        $curso = [];
        $serie_historica = [];
        if($request->filtro == 'departamento'){
            
       
            foreach(Util::getDepartamentos() as $key=>$dep){
                $departamentos[$key] = [];
                $departamentos[$key]['nome_departamento'] = $dep[1];
                
                $departamentos[$key]['ic_com_bolsa'] = ComissaoPesquisa::where('sigla_departamento',$key)->where('bolsa', 'true')->where('tipo', 'IC')->get()->count();
                $departamentos[$key]['ic_sem_bolsa'] = ComissaoPesquisa::where('sigla_departamento',$key)->where('bolsa', 'false')->where('tipo', 'IC')->get()->count();
                
                $departamentos[$key]['pesquisadores_colab'] = ComissaoPesquisa::where('sigla_departamento',$key)->where('tipo', 'PC')->get()->count();
                
                $departamentos[$key]['projetos_pesquisa'] = ComissaoPesquisa::where('sigla_departamento',$key)->where('tipo', 'PP')->get()->count();
                
                $departamentos[$key]['pesquisas_pos_doutorado_com_bolsa'] = ComissaoPesquisa::where('sigla_departamento',$key)->where('bolsa', 'true')->where('tipo', 'PD')->get()->count();
                $departamentos[$key]['pesquisas_pos_doutorado_sem_bolsa'] = ComissaoPesquisa::where('sigla_departamento',$key)->where('bolsa', 'false')->where('tipo', 'PD')->get()->count();
            
            }
        }else if($request->filtro  == 'serie_historica' && isset($request->ano_ini) && $request->ano_fim){
            
            $ano_ini = (int)$request->ano_ini ?? date('Y');
            $ano_fim = (int)$request->ano_fim ?? date('Y');
            $serie_historica_tipo = $request->serie_historica_tipo;
            if($serie_historica_tipo == 'curso'){
                foreach(Util::getCursos() as $key=>$cur){
                    $serie_historica[$cur] = [];
                    for($ano = $ano_ini; $ano <= $ano_fim; $ano++){
                        $serie_historica[$cur][$ano] = [];
                        $serie_historica[$cur][$ano]['ic_com_bolsa'] = ComissaoPesquisa::where(function ($query) use ($ano) {
                            $query->whereYear('data_ini', '=', $ano)
                                ->orWhere('ano_proj', '=', $ano);
                        })->where('bolsa', 'true')->where('tipo', 'IC')->where('cod_curso',$key)->get()->count();
        
                        $serie_historica[$cur][$ano]['ic_sem_bolsa'] = 
                        ComissaoPesquisa::where(function ($query) use ($ano) {
                            $query->whereYear('data_ini', '=', $ano)
                                ->orWhere('ano_proj', '=', $ano);
                        })->where('bolsa', 'false')->where('tipo', 'IC')->where('cod_curso',$key)->get()->count();
        
                        $serie_historica[$cur][$ano]['pesquisadores_colab'] = ComissaoPesquisa::where(function ($query) use ($ano) {
                            $query->whereYear('data_ini', '=', $ano)
                                ->orWhere('ano_proj', '=', $ano);
                        })->where('tipo', 'PC')->where('cod_curso',$key)->get()->count();
                                        
                        $serie_historica[$cur][$ano]['projetos_pesquisa'] = ComissaoPesquisa::where(function ($query) use ($ano) {
                            $query->whereYear('data_ini', '=', $ano)
                                ->orWhere('ano_proj', '=', $ano);
                        })->where('tipo', 'PP')->where('cod_curso',$key)->get()->count();
                        
                        $serie_historica[$cur][$ano]['pesquisas_pos_doutorado_com_bolsa'] = ComissaoPesquisa::where(function ($query) use ($ano) {
                            $query->whereYear('data_ini', '=', $ano)
                                ->orWhere('ano_proj', '=', $ano);
                        })->where('bolsa', 'true')->where('tipo', 'PD')->where('cod_curso',$key)->get()->count();
                        
                        $serie_historica[$cur][$ano]['pesquisas_pos_doutorado_sem_bolsa'] = ComissaoPesquisa::where(function ($query) use ($ano) {
                            $query->whereYear('data_ini', '=', $ano)
                                ->orWhere('ano_proj', '=', $ano);
                        })->where('bolsa', 'false')->where('tipo', 'PD')->where('cod_curso',$key)->get()->count();
                    }
                
                }
                
            }else{
                foreach(Util::getDepartamentos() as $key=>$dep){
                    $serie_historica[$dep[1]] = [];
                    for($ano = $ano_ini; $ano <= $ano_fim; $ano++){
                        $serie_historica[$dep[1]][$ano] = [];
                        $serie_historica[$dep[1]][$ano]['ic_com_bolsa'] = ComissaoPesquisa::where(function ($query) use ($ano) {
                            $query->whereYear('data_ini', '=', $ano)
                                ->orWhere('ano_proj', '=', $ano);
                        })->where('bolsa', 'true')->where('tipo', 'IC')->where('sigla_departamento',$key)->get()->count();
        
                        $serie_historica[$dep[1]][$ano]['ic_sem_bolsa'] = 
                        ComissaoPesquisa::where(function ($query) use ($ano) {
                            $query->whereYear('data_ini', '=', $ano)
                                ->orWhere('ano_proj', '=', $ano);
                        })->where('bolsa', 'false')->where('tipo', 'IC')->where('sigla_departamento',$key)->get()->count();
        
                        $serie_historica[$dep[1]][$ano]['pesquisadores_colab'] = ComissaoPesquisa::where(function ($query) use ($ano) {
                            $query->whereYear('data_ini', '=', $ano)
                                ->orWhere('ano_proj', '=', $ano);
                        })->where('tipo', 'PC')->where('sigla_departamento',$key)->get()->count();
                                        
                        $serie_historica[$dep[1]][$ano]['projetos_pesquisa'] = ComissaoPesquisa::where(function ($query) use ($ano) {
                            $query->whereYear('data_ini', '=', $ano)
                                ->orWhere('ano_proj', '=', $ano);
                        })->where('tipo', 'PP')->where('sigla_departamento',$key)->get()->count();
                        
                        $serie_historica[$dep[1]][$ano]['pesquisas_pos_doutorado_com_bolsa'] = ComissaoPesquisa::where(function ($query) use ($ano) {
                            $query->whereYear('data_ini', '=', $ano)
                                ->orWhere('ano_proj', '=', $ano);
                        })->where('bolsa', 'true')->where('tipo', 'PD')->where('sigla_departamento',$key)->get()->count();
                        
                        $serie_historica[$dep[1]][$ano]['pesquisas_pos_doutorado_sem_bolsa'] = ComissaoPesquisa::where(function ($query) use ($ano) {
                            $query->whereYear('data_ini', '=', $ano)
                                ->orWhere('ano_proj', '=', $ano);
                        })->where('bolsa', 'false')->where('tipo', 'PD')->where('sigla_departamento',$key)->get()->count();
                    }
                
                }
            }
            
    
        }else{ //cursos (default)
            foreach(Util::getCursos() as $key=>$c){
                $curso[$key] = [];
                $curso[$key]['nome_curso'] = $c;
                
                $curso[$key]['ic_com_bolsa'] = ComissaoPesquisa::where('cod_curso',$key)->where('bolsa', 'true')->where('tipo', 'IC')->get()->count();
                $curso[$key]['ic_sem_bolsa'] = ComissaoPesquisa::where('cod_curso',$key)->where('bolsa', 'false')->where('tipo', 'IC')->get()->count();

                $curso[$key]['pesquisadores_colab'] = ComissaoPesquisa::where('cod_curso',$key)->where('tipo', 'PC')->get()->count();
                
                $curso[$key]['projetos_pesquisa'] = ComissaoPesquisa::where('cod_curso',$key)->where('tipo', 'PP')->get()->count();

                $curso[$key]['pesquisas_pos_doutorado_com_bolsa'] = ComissaoPesquisa::where('cod_curso',$key)->where('bolsa', 'true')->where('tipo', 'PD')->get()->count();
                $curso[$key]['pesquisas_pos_doutorado_sem_bolsa'] = ComissaoPesquisa::where('cod_curso',$key)->where('bolsa', 'false')->where('tipo', 'PD')->get()->count();
            
            
            }
        }
        
      

        return view('pesquisa.index',[
            'filtro' => $request->filtro,
            'departamentos' => $departamentos,
            'curso' => $curso,
            'serie_historica' => $serie_historica,
        ]);
    }
    
    public function iniciacao_cientifica(Request $request){
        $nome_curso = '';
        $nome_departamento = '';

        if(isset($request->departamento)){
           
        
        
            $nome_departamento = Util::getDepartamentos()[$request->departamento][1];
            $bolsa = $request->bolsa == 'true' ? 'true' : 'false';
            $iniciacao_cientifica = ComissaoPesquisa::where('sigla_departamento',$request->departamento)->where('bolsa', $bolsa)->where('tipo', 'IC')->get()->toArray();
       
            $iniciacao_cientifica = $iniciacao_cientifica ?? null ;
        }else{
            
        
            $nome_curso = Util::getCursos()[$request->curso];
            $bolsa = $request->bolsa == 'true' ? 'true' : 'false';
            $iniciacao_cientifica = ComissaoPesquisa::where('cod_curso',$request->curso)->where('bolsa', $bolsa)->where('tipo', 'IC')->get()->toArray();
       
            $iniciacao_cientifica = $iniciacao_cientifica ?? null ;
        }
        
        return view('pesquisa.iniciacao_cientifica',[
            'filtro' => $request->filtro,
            'iniciacao_cientifica' => $iniciacao_cientifica,
            'nome_departamento' => $nome_departamento,
            'nome_curso' => $nome_curso,
        ]);
    }
    
    public function pesquisadores_colab(Request $request){
        $nome_departamento = '';
        $nome_curso = '';
        if(isset($request->departamento)){
            

            $nome_departamento = Util::getDepartamentos()[$request->departamento][1];
            $pesquisadores_colab = ComissaoPesquisa::where('sigla_departamento',$request->departamento)->where('tipo', 'PC')->get()->toArray();
            $pesquisadores_colab = $pesquisadores_colab ?? null;
        }else{
            
        
            $nome_curso = Util::getCursos()[$request->curso];
            $pesquisadores_colab = ComissaoPesquisa::where('cod_curso',$request->curso)->where('tipo', 'PC')->get()->toArray();
            $pesquisadores_colab = $pesquisadores_colab ?? null;

        }
        
        
        return view('pesquisa.pesquisadores_colab',[
            'filtro' => $request->filtro,
            'pesquisadores_colab' => $pesquisadores_colab,
            'nome_departamento' => $nome_departamento,
            'nome_curso' => $nome_curso,
        ]);
    }
    
    public function projetos_pesquisa(Request $request){
        $nome_departamento = '';
        $nome_curso = '';
        if(isset($request->departamento)){
            
            $nome_departamento = Util::getDepartamentos()[$request->departamento][1];
            $projetos_pesquisa = ComissaoPesquisa::where('sigla_departamento',$request->departamento)->where('tipo', 'PP')->get()->toArray();
            $projetos_pesquisa = $projetos_pesquisa ?? null;
        }else{
            
        
            $nome_curso = Util::getCursos()[$request->curso];
            $projetos_pesquisa = ComissaoPesquisa::where('cod_curso',$request->curso)->where('tipo', 'PP')->get()->toArray();
            $projetos_pesquisa = $projetos_pesquisa ?? null;

        }
        
        
        return view('pesquisa.projetos_pesquisa',[
            'filtro' => $request->filtro,
            'projetos_pesquisa' => $projetos_pesquisa,
            'nome_departamento' => $nome_departamento,
            'nome_curso' => $nome_curso,
        ]);
    }
    
    public function pesquisa_pos_doutorandos(Request $request){
        $nome_curso = '';
        $nome_departamento = '';

        if(isset($request->departamento)){
            
        
            $nome_departamento = Util::getDepartamentos()[$request->departamento][1];
            $bolsa = $request->bolsa == 'true' ? 'true' : 'false';

            $pd = ComissaoPesquisa::where('sigla_departamento',$request->departamento)->where('bolsa', $bolsa)->where('tipo', 'PD')->get()->toArray();
            $pd = $pd ?? null;
        }else{
            
            $nome_curso = Util::getCursos()[$request->curso];
            $bolsa = $request->bolsa == 'true' ? 'true' : 'false';
            $pd = ComissaoPesquisa::where('cod_curso',$request->curso)->where('bolsa', $bolsa)->where('tipo', 'PD')->get()->toArray();
       
            $pd = $pd ?? null ;
        }
        
        return view('pesquisa.pesquisas_pos_doutorando',[
            'filtro' => $request->filtro,
            'pesquisas_pos_doutorando' => $pd,
            'nome_departamento' => $nome_departamento,
            'nome_curso' => $nome_curso,
        ]);
    }
    
  
}
