<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\GenericChart;
use Uspdev\Cache\Cache;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;

class AlunosEspeciaisGrAnoController extends Controller
{
    private $data;
    private $excel;

    public function __construct(Excel $excel){
        $this->excel = $excel;
        $cache = new Cache();
        $data = [];
        $anos = ['2010', '2011', '2012', '2013','2014', '2015', '2016', '2017', '2018', '2019'];
        /* Contabiliza alunos especiais de graduação de 2010 até 2020 */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_aluno_especialgr.sql');
        foreach($anos as $ano){
            $query_por_ano = str_replace('__ano__', $ano, $query);
            $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query_por_ano);
            $data[$ano] = $result['computed'];
        }
        //query com os alunos especiais de graduação ativos no ano ATUAL
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_aluno_especialgr2020.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['2020'] = $result['computed'];

        $this->data = $data;
    }    
    
    public function grafico(){
        /* Tipos de gráficos:
         * https://www.highcharts.com/docs/chart-and-series-types/chart-types
         */
        $chart = new GenericChart;

        $chart->labels(array_keys($this->data));
        $chart->dataset('Quantidade de alunos especiais da Graduação por ano', 'line', array_values($this->data));

        return view('alunosEspeciaisGrAno', compact('chart'));
    }

    public function export($format){
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'AlunosEspeciaisGrAno.xlsx'); 
        }
    }
}

