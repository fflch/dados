<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\GenericChart;
use Uspdev\Cache\Cache;

class AtivosController extends Controller
{
    private $data;

    public function __construct(){

        $cache = new Cache();
        $data = [];

        /* Contabiliza aluno grad */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunogr.sql');

        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Graduação'] = $result['computed'];

        /* Contabiliza aluno pós */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunopos.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Pós-Graduação'] = $result['computed'];

        /* Contabiliza docentes */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_docentes.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Docentes'] = $result['computed'];

        /* Contabiliza funcionários */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_funcionarios.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Funcionários'] = $result['computed'];

        /* Contabiliza estagiários ativos */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_estagiario.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Estagiário'] = $result['computed'];

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
