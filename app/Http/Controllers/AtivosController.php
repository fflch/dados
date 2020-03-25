<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\GenericChart;
use Uspdev\Replicado\DB;


class AtivosController extends Controller
{
    private $data;
    public function __construct(){
        /** Queremos algo +/- assim:
          * $data = [
          *   'Graduação' => 100,
          *   'Pós-Graduação' => 205, 
          *   'Docentes'  => 89,
          *   'Funcionários(as)' => 56
          *  ];
          **/

        $data = [];

        /* Contabiliza aluno grad */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunogr.sql');
        $result = DB::fetch($query);
        $data['Graduação'] = $result['computed'];

        /* Contabiliza aluno pós */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunopos.sql');
        $result = DB::fetch($query);
        $data['Pós-Graduação'] = $result['computed'];

        $this->data = $data;
    }    
    
    public function grafico(){
        /* Tipos de gráficos:
         * https://www.highcharts.com/docs/chart-and-series-types/chart-types
         */
        $chart = new GenericChart;

        $chart->labels(array_keys($this->data));
        $chart->dataset('Quantidade', 'bar', array_values($this->data));

        return view('ativos', compact('chart'));
    }

    public function csv(){

        $data = collect($this->data);
        $csvExporter = new \Laracsv\Export(); //dd($data);
        $csvExporter->build($data, ['vinculo', 'quantidade'])->download();

    }

}
