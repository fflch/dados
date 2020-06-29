<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\GenericChart;
use Uspdev\Cache\Cache;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;

class AlunosAtivosAutodeclaradosController extends Controller
{
    private $data;
    private $excel;
    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
        $cache = new Cache();
        $data = [];

        // Array com código das cores/raça cadastradas no banco. 
        $cores = ['1', '2', '3', '4', '5', '6'];

        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunos_autodeclarados.sql');

        /* Contabiliza alunos da Graduação, Pós Graduação, Pós Doutorado e Cultura e Extensão
        autodeclarados */
        foreach ($cores as $cor) {
            $query_por_cor = str_replace('__cor__', $cor, $query);
            $result = $cache->getCached('\Uspdev\Replicado\DB::fetch', $query_por_cor);
            $data[$cor] = $result['computed'];
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
            'Indígena',
            'Branca',
            'Preta / Negra',
            'Amarela',
            'Parda',
            'Não informada',
        ]);
        $chart->dataset('Quantidade', 'bar', array_values($this->data));

        return view('ativosAlunosAutodeclarados', compact('chart'));
    }

    public function export($format)
    {
        if ($format == 'excel') {
            $export = new DadosExport([$this->data], array_keys($this->data));
            return $this->excel->download($export, 'alunos_ativos_autodeclarados.xlsx');
        }
    }
}
