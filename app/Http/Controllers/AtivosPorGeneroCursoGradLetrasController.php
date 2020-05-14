<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\GenericChart;
use Uspdev\Cache\Cache;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;

class AtivosPorGeneroCursoGradLetrasController extends Controller
{
    private $data;
    private $excel;

    public function __construct(Excel $excel){
        $this->excel = $excel;
        $cache = new Cache();
        $data = [];

        /* Contabiliza alunos graduação gênero feminino - letras */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunogr_letras_fem.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Feminino'] = $result['computed'];


        /* Contabiliza alunos graduação gênero masculino - letras */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunogr_letras_masc.sql');
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
        $chart->dataset('Letras por Gênero', 'bar', array_values($this->data));

        return view('ativosGradLetras', compact('chart'));
    }

    public function export($format)
    {
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'ativos_grad_genero_letras.xlsx'); 
        }
    }
}
