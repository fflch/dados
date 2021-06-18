<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Uspdev\Replicado\DB;
use Khill\Lavacharts\Lavacharts;


class OrientadoresPosGRContoller extends Controller
{
    private $data;
    private $excel;
    private $labels;
    public function __construct(Excel $excel){
        $this->excel = $excel;
        $data = [];
        $this->labels = [
            'AS' => 8134,
            'CP' => 8131,
            'ECLLP' => 8156,
            'EJ' => 8158,
            'DELLI' => 8147,
            'ET' => 8160,
            'FLP' => 8142,
            'DF' => 8133,
            'GF' => 8135,
            'GH' => 8136,
            'HE' => 8137,
            'HS' => 8138,
            'HDOL' => 8161,
            'LC' => 8143,
            'DL' => 8139,
            'LB' => 8149,
            'LP' => 8150,
            'LELEH' => 8145,
            'LLA' => 8144,
            'LLF' => 8146,
            'LLCI' => 8148,
            'DS' => 8132,
            'TLLC' => 8151,
        ];


        $areas = ['8134', '8131', '8156', '8158', '8147', '8160', '8142', '8133', '8135', '8136', '8137', '8138', '8161', '8143', '8139', '8149', '8150', '8145', '8144', '8146', '8148', '8132', '8151'];

        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_orientadores_posgr.sql');
        
        /* Contabiliza orientadores credenciados na área de concentração (codare) do programa de pós graduação correspondente*/
        foreach ($areas as $area){
            $query_por_area = str_replace('__area__', $area, $query);
            $result = DB::fetch($query_por_area);
            $data[$area] = $result['computed'];
        } 

        $this->data = $data;
    }

    public function grafico(){
        $labels = $this->labels;

    
        $lava = new Lavacharts; // See note below for Laravel

        $orientadores  = $lava->DataTable();
        $orientadores->addStringColumn('Área de Concentração')
            ->addNumberColumn('Quantidade');
            
        foreach($labels as $key=>$label){ 
            $orientadores->addRow([$key, $this->data[$label]]);
        }


        $lava->ColumnChart('Orientadores', $orientadores, [
            'legend' => [
                'position' => 'top',
                'alignment' => 'center',
                
            ],
            'height' => 500,
            'vAxis' => ['format' => 0],
            'colors' => ['#273e74']

        ]);

        return view('orientadoresPosGR', compact('lava'));
    }

    public function export($format){
        
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->labels));
            return $this->excel->download($export, 'orientadores_posgr.xlsx');
        }
    }
}
