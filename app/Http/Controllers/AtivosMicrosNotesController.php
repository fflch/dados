<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\GenericChart;
use Uspdev\Cache\Cache;

class AtivosMicrosNotesController extends Controller
{
    private $data;

    public function __construct(){

        $cache = new Cache();
        $data = [];

        /* Contabiliza microcomputadores */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_micros_ativos.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Microcomputadores'] = $result['computed'];

        /* Contabiliza notebooks */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_notes_ativos.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Notebooks'] = $result['computed'];

        $this->data = $data;
    }    
    
    public function grafico(){
	/* Tipos de gráficos:
         * https://www.highcharts.com/docs/chart-and-series-types/chart-types
         */
        $chart = new GenericChart;

        $chart->labels(array_keys($this->data));
        $chart->dataset('Quantidade', 'bar', array_values($this->data));

        return view('ativosmicrosnotes', compact('chart'));
    }

    public function csv(){

        $data = collect($this->data);
        $csvExporter = new \Laracsv\Export(); //dd($data);
        $csvExporter->build($data, ['vinculo', 'quantidade'])->download();
    }
}
