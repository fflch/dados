<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\GenericChart;
use Uspdev\Cache\Cache;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;

class AtivosPorGeneroMestrandosController extends Controller
{
    private $data;
    private $excel;

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
        $cache = new Cache();
        $data = [];

        /* Contabiliza alunos de mestrado do gênero feminino */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_mestrandos_fem.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['2010'] = $result['computed'];

        /* Contabiliza alunos de mestrado do gênero masculino */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_mestrandos_masc.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['2011'] = $result['computed'];

        $this->data = $data;
    }    
    
    public function grafico(){
        /* Tipos de gráficos:
         * https://www.highcharts.com/docs/chart-and-series-types/chart-types
         */
        $chart = new GenericChart;

        $chart->labels(array_keys($this->data));
        $chart->dataset('Gênero mestrandos', 'bar', array_values($this->data));

        return view('ativosMestrandos', compact('chart'));
    }

    public function export($format)
    {
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'ativos_mestrandos_genero.xlsx'); 
        }
    }
}
