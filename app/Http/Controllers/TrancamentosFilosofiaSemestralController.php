<?php

namespace App\Http\Controllers;

use App\Charts\GenericChart;
use Uspdev\Cache\Cache;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;

class TrancamentosFilosofiaSemestralController extends Controller
{
    private $data;
    private $excel;
    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
        $cache = new Cache();
        $data = [];

        // Array com os totais de trancamentos por semestre.  
        $semestres = [
            20141,
            20142,
            20151,
            20152,
            20161,
            20162,
            20171,
            20172,
            20181,
            20182,
            20191,
            20192,
            20201,
            20202,
        ];

        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_trancamentos.sql');

        /* Curso: Filosofia */
        $query = str_replace('__curso__', 8010, $query);

        /* Contabiliza trancamentos por semestre. */
        foreach ($semestres as $semestre) {
            $query_por_semestre = str_replace('__semestre__', $semestre, $query);
            $result = $cache->getCached('\Uspdev\Replicado\DB::fetch', $query_por_semestre);
            $data[$semestre] = $result['computed'];
        }
        $this->data = $data;
    }

    public function grafico()
    {
        /* Tipos de gráficos:
         * https://www.highcharts.com/docs/chart-and-series-types/chart-types
         */
        $chart = new GenericChart;
        $chart->labels([
            '1° semestre - 2014',
            '2° semestre - 2014',
            '1° semestre - 2015',
            '2° semestre - 2015',
            '1° semestre - 2016',
            '2° semestre - 2016',
            '1° semestre - 2017',
            '2° semestre - 2017',
            '1° semestre - 2018',
            '2° semestre - 2018',
            '1° semestre - 2019',
            '2° semestre - 2019',
            '1° semestre - 2020',
            '2° semestre - 2020',
        ]);
        $chart->dataset('Quantidade', 'bar', array_values($this->data));

        return view('trancamentosFilosofiaPorSemestre', compact('chart'));
    }

    public function export($format)
    {
        if ($format == 'excel') {
            $export = new DadosExport([$this->data], array_keys($this->data));
            return $this->excel->download($export, 'trancamentos_filosofia_semestral.xlsx');
        }
    }
}