<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        /* Contabiliza benefícios concedidos em 2014 */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_beneficios_2014.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['2014'] = $result['computed'];
        

        /* Contabiliza benefícios concedidos em 2015 */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_beneficios_2015.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['2015'] = $result['computed'];


        /* Contabiliza benefícios concedidos em 2016 */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_beneficios_2016.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['2016'] = $result['computed'];


        /* Contabiliza benefícios concedidos em 2017 */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_beneficios_2017.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['2017'] = $result['computed'];


        /* Contabiliza benefícios concedidos em 2018 */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_beneficios_2018.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['2018'] = $result['computed'];


        /* Contabiliza benefícios concedidos em 2019 */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_beneficios_2019.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['2019'] = $result['computed'];


        /* Contabiliza benefícios concedidos em 2020 */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_beneficios_2020.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['2020'] = $result['computed'];

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
