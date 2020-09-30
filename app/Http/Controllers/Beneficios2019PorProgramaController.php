<?php

namespace App\Http\Controllers;

use App\Charts\GenericChart;
use Uspdev\Cache\Cache;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;

class Beneficios2019PorProgramaController extends Controller
{
    private $data;
    private $excel;

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
        $cache = new Cache();
        $data = [];
        $beneficios = ['19','22','69','89','97','99','100','103','104'];

        /* Contabiliza benefícios 19 concedidos em 2019 */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_beneficios_2019.sql');
        foreach($beneficios as $beneficio){
            $query_por_beneficio = str_replace('__beneficio__',$beneficio,$query);
            $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query_por_beneficio);
            $data[$beneficio] = $result['computed'];
        }       

        $this->data = $data;
    }    
    
    public function grafico(){
        /* Tipos de gráficos:
         * https://www.highcharts.com/docs/chart-and-series-types/chart-types
         */
        $chart = new GenericChart;
        $chart->labels(array_keys($this->data));
        $chart->dataset('Benefícios concedidos em 2019 separados por programa', 'bar', array_values($this->data));

        return view('Benef2019Prog', compact('chart'));
    }

    public function export($format)
    {
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'beneficios_2019_por_programa.xlsx'); 
        }
    }
}
