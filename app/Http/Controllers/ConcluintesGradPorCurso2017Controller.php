<?php

namespace App\Http\Controllers;

use App\Charts\GenericChart;
use Uspdev\Cache\Cache;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;

class ConcluintesGradPorCurso2017Controller extends Controller
{
    private $data;
    private $excel;

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
        $cache = new Cache();
        $data = [];

        // Array cursos.  
        $cursos = [
            '8040',
            '8010',
            '8021',
            '8030',
            '8050, 8051, 8060',
        ];

        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_concluintes_grad_2017.sql');

        /* Contabiliza concluintes da graduação em 2017 por curso. */
        foreach ($cursos as $curso) {
            $query_por_curso = str_replace('__curso__', $curso, $query);
            $result = $cache->getCached('\Uspdev\Replicado\DB::fetch', $query_por_curso);
            $data[$curso] = $result['computed'];
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
            'Ciências Sociais',
            'Filosofia',
            'Geografia',
            'História',
            'Letras',
        ]);
        $chart->dataset('Concluintes da Graduação por curso em 2017', 'bar', array_values($this->data));

        return view('concluintesGrad2017PorCurso', compact('chart'));
    }

    public function export($format)
    {
        if ($format == 'excel') {
            $export = new DadosExport([$this->data], array_keys($this->data));
            return $this->excel->download($export, 'concluintes_grad_2017.xlsx');
        }
    }
}