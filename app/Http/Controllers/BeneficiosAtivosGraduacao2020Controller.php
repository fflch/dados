<?php

namespace App\Http\Controllers;

use App\Charts\GenericChart;
use Uspdev\Cache\Cache;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;

class BeneficiosAtivosGraduacao2020Controller extends Controller
{
    private $data;
    private $excel;
    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
        $cache = new Cache();
        $data = [];

        // Array com cód. dos benefícios oferecidos em 2020 (1º e 2º semestres) da graduação. 
        $beneficio = [
                    2,
                    5,
                    52,
                    102,
        ];

        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_beneficiosAtivos_graduacao_2020.sql');

        /* Contabiliza alunos da Graduação por tipo de beneficio */
        foreach ($beneficio as $codigo) {
            $query_por_codigo = str_replace('__codigo__', $codigo, $query);
            $result = $cache->getCached('\Uspdev\Replicado\DB::fetch', $query_por_codigo);
            $data[$codigo] = $result['computed'];
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
            '2 - Auxílio Alimentação',
            '5 - Auxílio Moradia',
            '52 - Bolsa PEEG',
            '102 - SEI - Auxílio Financeiro',
        ]);
        $chart->dataset('Quantidade', 'bar', array_values($this->data));

        return view('beneficiosAtivosGraduacao2020', compact('chart'));
    }

    public function export($format)
    {
        if ($format == 'excel') {
            $export = new DadosExport([$this->data], array_keys($this->data));
            return $this->excel->download($export, 'beneficios_ativos_graduacao_2020.xlsx');
        }
    }
}