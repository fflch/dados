<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\GenericChart;
use Uspdev\Cache\Cache;

class ConcluintesGradPorAnoController extends Controller
{
    private $data;
    public function __construct()
    {
        $cache = new Cache();
        $data = [];

        /* Contabiliza concluintes da graduação em 2014 */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_concluintes_grad_2014.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch', $query);
        $data['2014'] = $result['computed'];

        /* Contabiliza concluintes da graduação em 2015 */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_concluintes_grad_2015.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch', $query);
        $data['2015'] = $result['computed'];

        /* Contabiliza concluintes da graduação em 2016 */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_concluintes_grad_2016.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch', $query);
        $data['2016'] = $result['computed'];

        /* Contabiliza concluintes da graduação em 2017 */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_concluintes_grad_2017.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch', $query);
        $data['2017'] = $result['computed'];

        /* Contabiliza concluintes da graduação em 2018 */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_concluintes_grad_2018.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch', $query);
        $data['2018'] = $result['computed'];

        /* Contabiliza concluintes da graduação em 2019 */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_concluintes_grad_2019.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch', $query);
        $data['2019'] = $result['computed'];


        $this->data = $data;
    }

    public function grafico()
    {
        /* Tipos de gráficos:
         * https://www.highcharts.com/docs/chart-and-series-types/chart-types
         */
        $chart = new GenericChart;

        $chart->labels(array_keys($this->data));
        $chart->dataset('Concluintes da Graduação por ano', 'line', array_values($this->data));

        return view('concluintesGradPorAno', compact('chart'));
    }

    public function csv()
    {

        $data = collect($this->data);
        $csvExporter = new \Laracsv\Export(); //dd($data);
        $csvExporter->build($data, ['vinculo', 'quantidade'])->download();
    }
}
