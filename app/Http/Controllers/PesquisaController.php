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
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;


class PesquisaController extends Controller
{
    private $excel;
    private $data;

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
 
    }

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
            $nome_departamento = Util::getDepartamentos()[$request->departamento][1];
            $key_filtro = 'sigla_departamento';
            $value_filtro = $request->departamento;            
        }else{
            $nome_curso = Util::getCursos()[$request->curso];
            $key_filtro = 'cod_curso';
            $value_filtro = $request->curso;
        }

           // dd(ComissaoPesquisa::where('nome_discente', 'like', '%Rodrigo da Silva Rocha%')->get()->toArray());

        if($tipo == 'anual'){
            $iniciacao_cientifica = 
                ComissaoPesquisa::where(function ($query) use ($key_filtro, $value_filtro, $bolsa) {
                    return $query->where($key_filtro,$value_filtro)
                    ->where('bolsa', '=', $bolsa)
                    ->where('tipo', '=', 'IC');
                })->where(function ($query) use ($limit_ini) {
                    return $query->whereYear('data_ini', '=', $limit_ini)
                        ->orWhereYear('data_fim', '=', $limit_ini)
                        ->orWhereYear('ano_proj', '=', $limit_ini);
                })->get()->toArray();
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
   
        $iniciacao_cientifica = $iniciacao_cientifica ?? null ;
        $this->data = $iniciacao_cientifica;
        
        return view('pesquisa.iniciacao_cientifica',[
            'filtro' => $request->filtro,
            'iniciacao_cientifica' => $iniciacao_cientifica,
            'nome_departamento' => $nome_departamento,
            'nome_curso' => $nome_curso,
        ]);
    }


    public function exportar_iniciacao_cientifica($format)
    {
        if ($format == 'excel') {
            dd($this->data);
            $export = new DadosExport([$this->data], array_keys($this->data));
            return $this->excel->download($export, 'iniciacao_cientifica.xlsx');
        }
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
