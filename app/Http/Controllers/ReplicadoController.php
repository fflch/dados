<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\GenericChart;

class ReplicadoController extends Controller
{
    public function exemplo(){
        /* Tipos de gráficos:
         * https://www.highcharts.com/docs/chart-and-series-types/chart-types
         */
        $chart = new GenericChart;

        $data = [
          'Graduação' => 100,
          'Pós-Graduação' => 205, 
          'Docentes'  => 89,
          'Funcionários(as)' => 56
        ];

        $chart->labels(array_keys($data));
        $chart->dataset('Quantidade', 'bar', array_values($data));

        return view('exemplo', compact('chart'));
    }
}
