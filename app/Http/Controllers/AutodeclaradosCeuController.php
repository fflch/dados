<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\GenericChart;
use Uspdev\Cache\Cache;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;

class AutodeclaradosCeuController extends Controller
{
    private $data;
    private $excel;

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
        $cache = new Cache();
        $data = [];

        /* Contabiliza alunos indígenas CEU por raça/cor */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_ativos_ceu_indigenas.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch', $query);
        $data['Indígena'] = $result['computed'];

        /* Contabiliza alunos brancos(as) CEU por raça/cor */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_ativos_ceu_brancas.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch', $query);
        $data['Branca'] = $result['computed'];

        /* Contabiliza alunos negros(as) CEU por raça/cor */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_ativos_ceu_negras.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch', $query);
        $data['Preta / negra'] = $result['computed'];

        /* Contabiliza alunos amarelo(as) CEU por raça/cor */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_ativos_ceu_amarelas.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch', $query);
        $data['Amarela*'] = $result['computed'];

        /* Contabiliza alunos pardos(as) CEU por raça/cor */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_ativos_ceu_pardas.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch', $query);
        $data['Parda**'] = $result['computed'];

        /* Contabiliza alunos CEU não autodeclarados ou sem informações de raça/cor */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_ativos_ceu_raca_nao_informada.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch', $query);
        $data['Não informado***'] = $result['computed'];

        $this->data = $data;
    }

    public function grafico()
    {
        /* Tipos de gráficos:
         * https://www.highcharts.com/docs/chart-and-series-types/chart-types
         */
        $chart = new GenericChart;

        $chart->labels(array_keys($this->data));
        $chart->dataset('Quantidade de alunos(as) de Cultura e Extensão Universitária contabilizados por raça/cor.', 'bar', array_values($this->data));

        return view('autodeclaradosCeuAtivos', compact('chart'));
    }

    public function export($format)
    {
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'auto_declarados_ceu.xlsx'); 
        }
    }
}
