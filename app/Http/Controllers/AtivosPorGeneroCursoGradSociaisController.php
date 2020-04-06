<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\GenericChart;
use Uspdev\Cache\Cache;

class AtivosPorGeneroCursoGradSociaisController extends Controller
{
    private $data;
    public function __construct(){
        $cache = new Cache();
        $data = [];

        /* Contabiliza alunos graduação gênero feminino - sociais */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunogr_sociais_fem.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Feminino'] = $result['computed'];


        /* Contabiliza alunos graduação gênero masculino - sociais */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunogr_sociais_masc.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Masculino'] = $result['computed'];

        $this->data = $data;
    }    
    
    public function grafico(){
        /* Tipos de gráficos:
         * https://www.highcharts.com/docs/chart-and-series-types/chart-types
         */
        $chart = new GenericChart;

        $chart->labels(array_keys($this->data));
        $chart->dataset('Ciências Sociais por Gênero', 'bar', array_values($this->data));

        return view('ativosGradSociais', compact('chart'));
    }

    public function csv(){

        $data = collect($this->data);
        $csvExporter = new \Laracsv\Export(); //dd($data);
        $csvExporter->build($data, ['vinculo', 'quantidade'])->download();

    }
}
