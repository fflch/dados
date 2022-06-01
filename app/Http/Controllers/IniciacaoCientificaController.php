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
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PesquisaRequest;

class IniciacaoCientificaController extends Controller
{
    private $excel;
    private $nome_departamento;
    private $nome_curso;

    public function __construct(Request $request, Excel $excel, Auth $auth)
    {

        $this->excel = $excel;

        if(isset($request->departamento)){
            $this->nome_departamento = Util::getDepartamentos()[$request->departamento][1];          
        }else{
            $this->nome_curso = Util::getCursos()[$request->curso];
        }


    }
    
    public function index(PesquisaRequest $request){
        
        $data = ComissaoPesquisa::listarIniciacaoCientifica($request, Auth::check());
        
        if ($request->export == "true") {
            $result = [];
            $labels = [];
            $labels[] = 'Código Projeto';
            if(Auth::check()){
                $labels[] = 'Nusp aluno';
            }
            $labels[] = 'Nome aluno';
            $labels[] = 'Gênero aluno';
            $labels[] = 'Raça/cor aluno';
            $labels[] = 'Título Pesquisa';
            if(Auth::check()){
                $labels[] = 'Nusp supervisor';
            }
            $labels[] = 'Nome supervisor';
            $labels[] = 'Gênero supervisor';
            $labels[] = 'Data início';
            $labels[] = 'Data fim';
            $labels[] = 'Ano do projeto';
            $labels[] = 'Situação do projeto';
            $labels[] = 'Bolsa';
            $labels[] = 'Data início da bolsa';
            $labels[] = 'Data fim da bolsa';
            
            if(isset($request->departamento)){
                $labels[] = 'Departamento';
            }else{
                $labels[] = 'Curso';
            }
          
            foreach($data as $ic){
                $aux = [];
                $aux[] = $ic['codproj'];
                
                if(Auth::check()){
                    $aux[] = $ic['codpes_discente'];          
                }
                $aux[] = $ic['nome_discente'];
                $aux[] = $ic['genero_discente'];
                $aux[] = $ic['raca_cor_discente'];
                $aux[] = $ic['titulo_pesquisa'];
                if(Auth::check()){
                    $aux[] = $ic['codpes_supervisor'];          
                }
                $aux[] = $ic['nome_supervisor'];
                $aux[] = $ic['genero_supervisor'];
                if(isset($ic['data_ini']) && $ic['data_ini'] != null){
                    $aux[] = Util::formatarData('Y-m-d H:i:s', 'd/m/Y', $ic['data_ini']);
                }else{
                    $aux[] = '-';
                }
                if(isset($ic['data_fim']) && $ic['data_fim'] != null){
                    $aux[] = Util::formatarData('Y-m-d H:i:s', 'd/m/Y', $ic['data_fim']);
                }else{
                    $aux[] = '-';
                }
                $aux[] = $ic['ano_proj'] ?? '-';
                $aux[] = $ic['status_projeto'] ?? '-';
                $aux[] = $ic['bolsa'] == true ? 'Sim' : 'Não';
                if(isset($ic['dtainibol']) && $ic['dtainibol'] != null){
                    $aux[] = Util::formatarData('Y-m-d', 'd/m/Y', $ic['dtainibol']);
                }else{
                    $aux[] = '-';
                }
                if(isset($ic['dtafimbol']) && $ic['dtafimbol'] != null){
                    $aux[] = Util::formatarData('Y-m-d', 'd/m/Y', $ic['dtafimbol']);
                }else{
                    $aux[] = '-';
                }
               
                
                if(isset($request->departamento)){
                    $aux[] = $ic['nome_departamento'];          
                }else{
                    $aux[] = $ic['nome_curso'];    
                }
                array_push($result, $aux);
                
            }
            $export = new DadosExport([$result], $labels);
            return $this->excel->download($export, 'iniciacao_cientifica.xlsx');
        }else{
            return view('pesquisa.iniciacao_cientifica',[
                'filtro' => $request->filtro,
                'iniciacao_cientifica' => $data,
                'nome_departamento' => $this->nome_departamento,
                'nome_curso' => $this->nome_curso,
                ]);
        }
    }    
  
}
