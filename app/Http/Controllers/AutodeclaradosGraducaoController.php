<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\GenericChart;
use Uspdev\Cache\Cache;

class AutodeclaradosGraducaoController extends Controller
{
    private $data;
    public function __construct()
    {
        $cache = new Cache();
        $data = [];

        /* Contabiliza alunos indígenas da graduação por raça/cor */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_ativos_grad_indigenas.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch', $query);
        $data['Indígena'] = $result['computed'];

        /* Contabiliza alunos brancos(as) da graduação por raça/cor */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_ativos_grad_brancas.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch', $query);
        $data['Branca'] = $result['computed'];

        /* Contabiliza alunos negros(as) da graduação por raça/cor */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_ativos_grad_negras.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch', $query);
        $data['Preta / negra'] = $result['computed'];

        /* Contabiliza alunos amarelo(as) da graduação por raça/cor */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_ativos_grad_amarelas.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch', $query);
        $data['Amarela*'] = $result['computed'];

        /* Contabiliza alunos pardos(as) da graduação por raça/cor */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_ativos_grad_pardas.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch', $query);
        $data['Parda**'] = $result['computed'];

        /* Contabiliza alunos da graduação não autodeclarados ou sem informações de raça/cor */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_ativos_grad_raca_nao_informada.sql');
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
        $chart->dataset('Quantidade de alunos(as) da Graduação contabilizados por raça/cor.', 'bar', array_values($this->data));

        return view('autodeclaradosGradAtivos', compact('chart'));
    }

    public function csv()
    {

        $data = collect($this->data);
        $csvExporter = new \Laracsv\Export(); //dd($data);
        $csvExporter->build($data, ['vinculo', 'quantidade'])->download();
    }
}
