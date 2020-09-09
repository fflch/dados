<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\GenericChart;
use Uspdev\Cache\Cache;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;

class AtivosPorGeneroPDController extends Controller
{
    private $data;
    private $excel;

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
        $cache = new Cache();
        $data = [];

        // Array com os gêneros.  
        $generos = ['F', 'M'];

        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunopd_genero.sql');

        /* Contabiliza alunos pós doutorando por gênero. */
        foreach ($generos as $genero) {
            $query_por_genero = str_replace('__genero__', $genero, $query);
            $result = $cache->getCached('\Uspdev\Replicado\DB::fetch', $query_por_genero);
            $data[$genero] = $result['computed'];
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
            'Feminino',
            'Masculino',
        ]);
        $chart->dataset('Pós-doutorando por Gênero', 'bar', array_values($this->data));

        return view('ativosPosDoutorado', compact('chart'));
    }

    public function export($format)
    {
        if ($format == 'excel') {
            $export = new DadosExport([$this->data], array_keys($this->data));
            return $this->excel->download($export, 'ativos_genero_pd.xlsx');
        }
    }
}