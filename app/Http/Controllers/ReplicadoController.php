<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\GenericChart;


class ReplicadoController extends Controller
{
    private static function getData(){
        $data = [
          'Graduação' => 100,
          'Pós-Graduação' => 205, 
          'Docentes'  => 89,
          'Funcionários(as)' => 56
        ];
        return $data;
    }    
    
    public function exemplo(){
        /* Tipos de gráficos:
         * https://www.highcharts.com/docs/chart-and-series-types/chart-types
         */
        $chart = new GenericChart;
        $data = self::getData();

        $chart->labels(array_keys($data));
        $chart->dataset('Quantidade', 'bar', array_values($data));

        return view('exemplo', compact('chart'));
    }

    public function exemploCsv(){

        $data = self::getData();
        $data = collect($data);
        $csvExporter = new \Laracsv\Export(); //dd($data);
        $csvExporter->build($data, ['vinculo', 'quantidade'])->download();

    }

}
