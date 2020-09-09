<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\GenericChart;
use Uspdev\Cache\Cache;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;

class AlunosEspeciaisPosGrDptoController extends Controller
{
    private $data;
    private $excel;

    public function __construct(Excel $excel){
        $this->excel = $excel;
        $cache = new Cache();
        $data = [];
        $dptos = ['8134', '8131', '8156', '8158', '8147', '8160', '8142', '8133', '8135', '8136', '8137', '8138', '8161', '8143', '8016', '8139', '8149', '8150', '8145', '8144', '8146', '8148', '8132', '8151'];
        /* Contabiliza alunos especiais ativos de pós-graduação, por departamento */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunosposgr_especiais_dpto.sql');
        foreach($dptos as $dpto){
            $query_por_dpto = str_replace('__dpto__', $dpto, $query);
            $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query_por_dpto);
            $data[$dpto] = $result['computed'];
        }

        $this->data = $data;
    }    
    
    public function grafico(){
        /* Tipos de gráficos:
         * https://www.highcharts.com/docs/chart-and-series-types/chart-types
         */
        $chart = new GenericChart;
        $chart->labels([
            'AS',
            'CP',
            'ECLLP',
            'EJ',
            'DELLI',
            'ET',
            'FLP',
            'DF',
            'GF',
            'GH',
            'HE',
            'HS',
            'DOL',
            'LC',
            'LET',
            'DL',
            'LB',
            'LP',
            'LELEH',
            'LLA',
            'LLF',
            'LLCI',
            'DS',
            'TLLC',
        ]);
        $chart->dataset('Quantidade', 'bar', array_values($this->data));

        return view('alunosEspeciaisPosGrDpto', compact('chart'));
    }

    public function export($format){
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'alunosEspeciaisPosGrDpto.xlsx'); 
        }
    }
}

