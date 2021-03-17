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
    public $aux_departamentos = ['FLA' => 'Antropologia',
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

    public $aux_cursos = [
        8010 => 'Filosofia',
        8021 => 'Geografia',
        8030 => 'História',
        8040 => 'Ciências Sociais',
        8051 => 'Letras',
    ];

    public function index(Request $request){
        $departamentos = [];
        $curso = [];
        if($request->filtro == 'departamento'){
            
       
            foreach($this->aux_departamentos as $key=>$dep){
                $departamentos[$key] = [];
                $departamentos[$key]['nome_departamento'] = $dep;
                
                $departamentos[$key]['ic_com_bolsa'] = ComissaoPesquisa::where('sigla_departamento',$key)->where('bolsa', 'true')->where('tipo', 'IC')->get()->count();
                $departamentos[$key]['ic_sem_bolsa'] = ComissaoPesquisa::where('sigla_departamento',$key)->where('bolsa', 'false')->where('tipo', 'IC')->get()->count();
                
                $departamentos[$key]['pesquisadores_colab'] = ComissaoPesquisa::where('sigla_departamento',$key)->where('tipo', 'PC')->get()->count();
                
                $departamentos[$key]['pesquisas_pos_doutorado_com_bolsa'] = ComissaoPesquisa::where('sigla_departamento',$key)->where('bolsa', 'true')->where('tipo', 'PD')->get()->count();
                $departamentos[$key]['pesquisas_pos_doutorado_sem_bolsa'] = ComissaoPesquisa::where('sigla_departamento',$key)->where('bolsa', 'false')->where('tipo', 'PD')->get()->count();
            
            }
        }else{
            
            
            
            foreach($this->aux_cursos as $key=>$c){
                $curso[$key] = [];
                $curso[$key]['nome_curso'] = $c;
                
                $curso[$key]['ic_com_bolsa'] = ComissaoPesquisa::where('cod_curso',$key)->where('bolsa', 'true')->get()->count();
                $curso[$key]['ic_sem_bolsa'] = ComissaoPesquisa::where('cod_curso',$key)->where('bolsa', 'false')->get()->count();

                $curso[$key]['pesquisadores_colab'] = ComissaoPesquisa::where('cod_curso',$key)->where('tipo', 'PC')->get()->count();

                $curso[$key]['pesquisas_pos_doutorado_com_bolsa'] = ComissaoPesquisa::where('cod_curso',$key)->where('bolsa', 'true')->where('tipo', 'PD')->get()->count();
                $curso[$key]['pesquisas_pos_doutorado_sem_bolsa'] = ComissaoPesquisa::where('cod_curso',$key)->where('bolsa', 'false')->where('tipo', 'PD')->get()->count();
            
            
            }
        }
        
      

        return view('pesquisa.index',[
            'filtro' => $request->filtro,
            'departamentos' => $departamentos,
            'curso' => $curso,
        ]);
    }
    
    public function iniciacao_cientifica(Request $request){
        $nome_curso = '';
        $nome_departamento = '';

        if(isset($request->departamento)){
           
        
        
            $nome_departamento = $this->aux_departamentos[$request->departamento];
            $bolsa = $request->bolsa == 'true' ? 'true' : 'false';
            $iniciacao_cientifica = ComissaoPesquisa::where('sigla_departamento',$request->departamento)->where('bolsa', $bolsa)->where('tipo', 'IC')->get()->toArray();
       
            $iniciacao_cientifica = $iniciacao_cientifica ?? null ;
        }else{
            
        
            $nome_curso = $this->aux_cursos[$request->curso];
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
            

            $nome_departamento = $this->aux_departamentos[$request->departamento];
            $pesquisadores_colab = ComissaoPesquisa::where('sigla_departamento',$request->departamento)->where('tipo', 'PC')->get()->toArray();
            $pesquisadores_colab = $pesquisadores_colab ?? null;
        }else{
            
        
            $nome_curso = $this->aux_cursos[$request->curso];
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
    
    public function pesquisa_pos_doutorandos(Request $request){
        $nome_curso = '';
        $nome_departamento = '';

        if(isset($request->departamento)){
            
        
            $nome_departamento = $this->aux_departamentos[$request->departamento];
            $bolsa = $request->bolsa == 'true' ? 'true' : 'false';

            $pd = ComissaoPesquisa::where('sigla_departamento',$request->departamento)->where('bolsa', $bolsa)->where('tipo', 'PD')->get()->toArray();
            $pd = $pd ?? null;
        }else{
            
            $nome_curso = $this->aux_cursos[$request->curso];
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
