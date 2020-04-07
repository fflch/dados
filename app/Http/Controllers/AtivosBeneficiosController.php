<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\GenericChart;
use Uspdev\Cache\Cache;

class AtivosBeneficiosController extends Controller
{
    private $data;

    public function __construct(){

        $cache = new Cache();
        $data = [];

        /* Contabiliza pessoas com beneficios ativos em 2020 */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_beneficios.sql');

        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Beneficios'] = $result['computed'];

        $this->data = $data;
    }    
    
    public function grafico(){
        /* Tipos de gráficos:
         * https://www.highcharts.com/docs/chart-and-series-types/chart-types
         */
        $chart = new GenericChart;

        $chart->labels(array_keys($this->data));
        $chart->dataset('Quantidade', 'bar', array_values($this->data));

        return view('ativosBeneficios', compact('chart'));
    }

    public function csv(){

        $data = collect($this->data);
        $csvExporter = new \Laracsv\Export(); //dd($data);
        $csvExporter->build($data, ['vinculo', 'quantidade'])->download();

    }

}
