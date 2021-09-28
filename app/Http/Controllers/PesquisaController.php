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

    public function contarPesquisasAtivasPorTipo(Request $request){
        $data = ComissaoPesquisa::contarPesquisasAtivasPorTipo($request);
      

        return view('pesquisa.index',[
            'filtro' => $request->filtro,
            'data' => $data,
        ]);
    }
    

    public function listarPesquisadoresColaboradores(Request $request){
        $nome_departamento = '';
        $nome_curso = '';
        if(isset($request->departamento)){
            $nome_departamento = Util::getDepartamentos()[$request->departamento][1];
        }else{
            $nome_curso = Util::getCursos()[$request->curso];
        }
        
        return view('pesquisa.pesquisadores_colab',[
            'filtro' => $request->filtro,
            'pesquisadores_colab' => ComissaoPesquisa::listarPesquisadoresColaboradores($request),
            'nome_departamento' => $nome_departamento,
            'nome_curso' => $nome_curso,
        ]);
    }
    
    public function listarProjetosPesquisa(Request $request){
        $nome_departamento = '';
        $nome_curso = '';
        if(isset($request->departamento)){
            $nome_departamento = Util::getDepartamentos()[$request->departamento][1];
        }else{
            $nome_curso = Util::getCursos()[$request->curso];
        }
        
        
        return view('pesquisa.projetos_pesquisa',[
            'filtro' => $request->filtro,
            'projetos_pesquisa' => ComissaoPesquisa::listarProjetosPesquisa($request),
            'nome_departamento' => $nome_departamento,
            'nome_curso' => $nome_curso,
        ]);
    }
    
    public function listarPesquisasPosDoutorandos(Request $request){
        $nome_curso = '';
        $nome_departamento = '';

        if(isset($request->departamento)){
            $nome_departamento = Util::getDepartamentos()[$request->departamento][1];
        }else{
            $nome_curso = Util::getCursos()[$request->curso];
        }
        
        return view('pesquisa.pesquisas_pos_doutorando',[
            'filtro' => $request->filtro,
            'pesquisas_pos_doutorando' => ComissaoPesquisa::listarPesquisasPosDoutorandos($request),
            'nome_departamento' => $nome_departamento,
            'nome_curso' => $nome_curso,
        ]);
    }
    
  
}
