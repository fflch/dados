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
            $this->nome_departamento = Util::getDepartamentos()[$request->departamento][1];
            $key_filtro = 'sigla_departamento';
            $value_filtro = $request->departamento;            
        }else{
            $this->nome_curso = Util::getCursos()[$request->curso];
            $key_filtro = 'cod_curso';
            $value_filtro = $request->curso;
        }


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
 
    }
    
    public function iniciacao_cientifica(Request $request){
        
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
