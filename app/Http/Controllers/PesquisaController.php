<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Uspdev\Replicado\Posgraduacao;
use Uspdev\Replicado\Pessoa;
use App\Utils\ReplicadoTemp;
use App\Models\Lattes as LattesModel;
use App\Models\Programa;
use App\Models\ComissaoPesquisa;

class PesquisaController extends Controller
{
    public function index(Request $request){
        
        $aux_departamentos = ['FLA' => 'Antropologia',
                          'FLP' => 'Ciência Política',
                          'FLF' => 'Filosofia',
                          'FLH' => 'História',
                          'FLC' => 'Letras Clássicas e Vernáculas',
                          'FLM' => 'Letras Modernas',
                          'FLO' => 'Letras Orientais',
                          'FLL' => 'Linguística',
                          'FSL' => 'Sociologia',
                          'FLT' => 'Teoria Literária e Literatura Comparada',
                          'FLG' => 'Geografia'
                        ];

        
        $departamentos = [];
        
       
        foreach($aux_departamentos as $key=>$dep){
            $departamentos[$key] = [];
            $departamentos[$key]['nome_departamento'] = $dep;
            
            $departamentos[$key]['ic'] = ComissaoPesquisa::where('sigla_departamento',$key)->get()->count();
            
            $departamentos[$key]['pesquisadores_colab'] = Pessoa::listarPesquisadoresColaboradoresAtivos($key);
            $departamentos[$key]['pesquisadores_colab'] = is_array($departamentos[$key]['pesquisadores_colab']) ? count($departamentos[$key]['pesquisadores_colab']) : 0;
        
        }
        
      

        return view('pesquisa.index',[
            'filtro' => $request->filtro,
            'departamentos' => $departamentos,
        ]);
    }
    
    public function iniciacao_cientifica(Request $request){

        $aux_departamentos = ['FLA' => 'Antropologia',
                          'FLP' => 'Ciência Política',
                          'FLF' => 'Filosofia',
                          'FLH' => 'História',
                          'FLC' => 'Letras Clássicas e Vernáculas',
                          'FLM' => 'Letras Modernas',
                          'FLO' => 'Letras Orientais',
                          'FLL' => 'Linguística',
                          'FSL' => 'Sociologia',
                          'FLT' => 'Teoria Literária e Literatura Comparada',
                          'FLG' => 'Geografia'
                        ];

        if(isset($request->departamento)){
            $nome_departamento = $aux_departamentos[$request->departamento];
            $iniciacao_cientifica = ComissaoPesquisa::where('sigla_departamento',$request->departamento)->get()->toArray();
            //dd($iniciacao_cientifica);
            $iniciacao_cientifica = $iniciacao_cientifica ?? null ;
        }
        
        
        return view('pesquisa.iniciacao_cientifica',[
            'filtro' => $request->filtro,
            'iniciacao_cientifica' => $iniciacao_cientifica,
            'nome_departamento' => $nome_departamento,
        ]);
    }
    
    public function pesquisadores_colab(Request $request){

        $aux_departamentos = ['FLA' => 'Antropologia',
                          'FLP' => 'Ciência Política',
                          'FLF' => 'Filosofia',
                          'FLH' => 'História',
                          'FLC' => 'Letras Clássicas e Vernáculas',
                          'FLM' => 'Letras Modernas',
                          'FLO' => 'Letras Orientais',
                          'FLL' => 'Linguística',
                          'FSL' => 'Sociologia',
                          'FLT' => 'Teoria Literária e Literatura Comparada',
                          'FLG' => 'Geografia'
                        ];

        if(isset($request->departamento)){
            $nome_departamento = $aux_departamentos[$request->departamento];
            $pesquisadores_colab = Pessoa::listarPesquisadoresColaboradoresAtivos($request->departamento);
            $pesquisadores_colab = $pesquisadores_colab ?? null;
        }
        
        
        return view('pesquisa.pesquisadores_colab',[
            'filtro' => $request->filtro,
            'pesquisadores_colab' => $pesquisadores_colab,
            'nome_departamento' => $nome_departamento,
        ]);
    }
    
    public function pesquisa_pos_doutorandos(Request $request){
        dd(Pessoa::listarPesquisaPosDoutorandos());

        $aux_departamentos = ['FLA' => 'Antropologia',
                          'FLP' => 'Ciência Política',
                          'FLF' => 'Filosofia',
                          'FLH' => 'História',
                          'FLC' => 'Letras Clássicas e Vernáculas',
                          'FLM' => 'Letras Modernas',
                          'FLO' => 'Letras Orientais',
                          'FLL' => 'Linguística',
                          'FSL' => 'Sociologia',
                          'FLT' => 'Teoria Literária e Literatura Comparada',
                          'FLG' => 'Geografia'
                        ];

        if(isset($request->departamento)){
            $nome_departamento = $aux_departamentos[$request->departamento];
            $pesquisadores_colab = Pessoa::listarPesquisadoresColaboradoresAtivos($request->departamento);
            $pesquisadores_colab = $pesquisadores_colab ?? null;
        }
        
        
        return view('pesquisa.pesquisadores_colab',[
            'filtro' => $request->filtro,
            'pesquisadores_colab' => $pesquisadores_colab,
            'nome_departamento' => $nome_departamento,
        ]);
    }
    
  
}
