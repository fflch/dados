<?php

namespace App\Http\Controllers;

use App\Charts\GenericChart;
use Uspdev\Cache\Cache;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;

class OrientadoresPosGRContoller extends Controller
{
    private $data;
    private $excel;
    public function __construct(Excel $excel){
        $this->excel = $excel;
        $cache = new Cache();
        $data = [];

        $areas = ['8134', '8131', '8156', '8158', '8147', '8160', '8142', '8133', '8135', '8136', '8137', '8138', '8161', '8143', '8139', '8149', '8150', '8145', '8144', '8146', '8148', '8132', '8151'];

        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_orientadores_posgr.sql');
        /* Contabiliza orientadores credenciados na área de concentração (codare) do programa de pós graduação correspondente*/
        foreach ($areas as $area){
            $query_por_area = str_replace('__area__', $area, $query);
            $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query_por_area);
            $data[$area] = $result['computed'];
        } 

        $this->data = $data;
    }

    public function grafico(){
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
            'HDOL',
            'LC',
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

        return view('orientadoresPosGR', compact('chart'));
    }

    public function export($format){
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'orientadores_posgr.xlsx');
        }
    }
}
