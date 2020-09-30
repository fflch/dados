<?php

namespace App\Http\Controllers;

use App\Charts\GenericChart;
use Uspdev\Cache\Cache;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;

class BeneficiosConcedidosHistoricoController extends Controller
{
    private $data;
    private $excel;

    public function __construct(Excel $excel){
        $this->excel = $excel;
        $cache = new Cache();
        $data = [];

        $anos = ['2014', '2015', '2016', '2017', '2018', '2019', '2020',];

        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_beneficios_ano.sql');
        /* Contabiliza benefícios concedidos de 2014-2020 */
        foreach($anos as $ano){
        $query_por_ano = str_replace('__ano__', $ano, $query);
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query_por_ano);
        $data[$ano] = $result['computed'];
        }        

        $this->data = $data;
    }    
    
    public function grafico(){
        /* Tipos de gráficos:
         * https://www.highcharts.com/docs/chart-and-series-types/chart-types
         */
        $chart = new GenericChart;

        $chart->labels(array_keys($this->data));
        $chart->dataset('Benefícios concedidos por ano', 'line', array_values($this->data));

        return view('ativosBeneficiosConHist', compact('chart'));
    }

    public function export($format)
    {
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'historico_beneficios_concedidos.xlsx'); 
        }
    }
}
