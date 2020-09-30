<?php

namespace App\Http\Controllers;

use App\Charts\GenericChart;
use Uspdev\Cache\Cache;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;

class AtivosDocentesPorFuncaoController extends Controller
{
    private $data;
    private $excel;

    public function __construct(Excel $excel){
        $this->excel = $excel;
        $cache = new Cache();
        $data = [];

        $tipos = ['Prof Titular', 'Prof Doutor', 'Prof Associado',];

        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_docentes_funcao.sql');

        foreach ($tipos as $tipo){
            $query_por_funcao = str_replace('__tipo__', $tipo, $query);
            $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query_por_funcao);
            $data[$tipo] = $result['computed'];
        }        

        $this->data = $data;
    }    
    
    public function grafico(){
        /* Tipos de gráficos:
         * https://www.highcharts.com/docs/chart-and-series-types/chart-types
         */
        $chart = new GenericChart;

        $chart->labels(array_keys($this->data));
        $chart->dataset('Quantidade', 'bar', array_values($this->data));

        return view('ativosDocentesPorFuncao', compact('chart'));
    }

    public function export($format){
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'docentes_funcao.xlsx');
        }
    }

}
