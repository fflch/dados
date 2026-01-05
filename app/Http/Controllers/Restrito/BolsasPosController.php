<?php

namespace App\Http\Controllers\Restrito;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;

use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Uspdev\Replicado\DB;
use Uspdev\Replicado\Lattes;
use App\Utils\Util;
use Illuminate\Support\Facades\Log;

class BolsasPosController extends Controller
{
    var $colNames =[
        'Area', 
	    'NumeroUSPAluno', 
	    'NomeAluno', 
	    'EmailAluno', 
	    'DataInicioPrazo', 
	    'DataLimiteDeposito', 
	    'Nivel',
        'Fomento',
        'NFomento'
    ];
    
    function listarPlanilha(Excel $excel, Request $request){
        Gate::authorize('admin');

        /* $sigla = $request->departamento;
        if (is_null($sigla) || !(in_array($sigla,array_keys(Util::departamentos)))) {
            abort(404,'Departamento não existe');
        }
        $dep = Util::departamentos[$sigla]; */

        $query = file_get_contents(__DIR__ . '/../../../../Queries/listar_posgr_por_ano_e_area.sql');
        //$query = str_replace('__area__', 8138, $query);
        //$query = str_replace('__ano__', 2025, $query);

        $data = DB::fetchAll($query);
        
        $export = new DadosExport([$data],
        $this->colNames);

        return $excel->download($export, '8138'. 'Bolsas.xlsx');
    
        
    }
    function listarTabela($sigla, Request $request){
        Gate::authorize('admin');

        if (is_null($sigla) || !(in_array($sigla,array_keys(Util::departamentos)))) {
            abort(404,'Departamento não existe');
            return;
        }
        $dep = Util::departamentos[$sigla];

        $query = file_get_contents(__DIR__ . '/../../../../Queries/listar_ProjetosPD.sql');
        $query = str_replace('__dep__', $dep[0], $query);
        $query = str_replace('__ano__', 2025, $query);

        $data = DB::fetchAll($query);
        

        return view('projetosPD',[
            'table_labels' => $this->colNames,
            'table_keys' => array_keys($data[0]) ,
            'table_data' => $data,
            'page_title' => $dep[1]
        ]);
    
        
    }
    function grafico(){
        $query = file_get_contents(__DIR__ . '/../../../../Queries/contagem_ProjetosPD.sql');
        $query = str_replace('__ano__', 2025, $query);

        $dados = DB::fetchAll($query);
        
        $labels = array_map(function($v){ return $v['NomeDepartamento'];},$dados);
        $data = array_map(function($v){ return $v['projetos'];},$dados);
        $nm = 'Projetos';
        return view('projetosPDgrafico',[ "chart_labels" => $labels, 'chart_data' => $data , 'chart_name_value' => $nm]);
    
    }
}
