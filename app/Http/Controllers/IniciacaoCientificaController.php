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


class IniciacaoCientificaController extends Controller
{
    private $excel;
    private $data;
    private $nome_departamento;
    private $nome_curso;

    public function __construct(Request $request, Excel $excel)
    {
        $this->excel = $excel;

        if(isset($request->departamento)){
            $this->nome_departamento = Util::getDepartamentos()[$request->departamento][1];          
        }else{
            $this->nome_curso = Util::getCursos()[$request->curso];
        }

        $this->data = ComissaoPesquisa::listarIniciacaoCientifica($request);
 
    }
    
    public function index(Request $request){
        
        if ($request->export == "true") {
            $result = [];
            $labels = [];
            $labels[] = 'Código Projeto';
            if(Auth::check()){
                $labels[] = 'Nusp aluno';
            }
            $labels[] = 'Nome aluno';
            $labels[] = 'Título Pesquisa';
            if(Auth::check()){
                $labels[] = 'Nusp supervisor';
            }
            $labels[] = 'Nome Supervisor';
            $labels[] = 'Data início';
            $labels[] = 'Data fim';
            $labels[] = 'Ano do projeto';
            $labels[] = 'Bolsa';
            $labels[] = 'Situação';
            if(isset($request->departamento)){
                $labels[] = 'Departamento';
            }else{
                $labels[] = 'Curso';
            }
          
            foreach($this->data as $ic){
                $aux = [];
                $aux[] = $ic['codproj'];
                if(Auth::check()){
                    $aux[] = $ic['codpes_discente'];          
                }
                $aux[] = $ic['nome_discente'];
                $aux[] = $ic['titulo_pesquisa'];
                if(Auth::check()){
                    $aux[] = $ic['codpes_supervisor'];          
                }
                $aux[] = $ic['nome_supervisor'];
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
                $aux[] = $ic['bolsa'] == true ? 'Sim' : 'Não';
                $aux[] = $ic['status_projeto'] ?? '-';
                
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
                'iniciacao_cientifica' => $this->data,
                'nome_departamento' => $this->nome_departamento,
                'nome_curso' => $this->nome_curso,
                ]);
        }
    }    
  
}
