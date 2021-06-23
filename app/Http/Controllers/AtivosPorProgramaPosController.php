<?php

namespace App\Http\Controllers;

use Uspdev\Replicado\DB;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use App\Utils\Util;
use Khill\Lavacharts\Lavacharts;

class AtivosPorProgramaPosController extends Controller
{
    private $data;
    private $excel;

    public function __construct(Excel $excel){

        $this->excel = $excel;
       
        $data = [];
        foreach(Util::getAreas() as $key=>$area){
            $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunos_pos_por_programa.sql');
            $query = str_replace('__codare__', $key, $query);
            $result = DB::fetch($query);
            $data[$area] = $result['computed'];
        }

        $this->data = $data;
    }    
    
    public function grafico(){

        $lava = new Lavacharts; // See note below for Laravel

        $ativos  = $lava->DataTable();
        $ativos->addStringColumn('Programa')
            ->addNumberColumn('Quantidade');
            
        foreach($this->data as $key=>$data){ 
            $ativos->addRow([$key, $data]);
        }


        $lava->ColumnChart('Ativos', $ativos, [
            'legend' => [
                'position' => 'top',
                'alignment' => 'center',
                
            ],
            'height' => 500,
            'vAxis' => ['format' => 0],
            'colors' => ['#273e74']
        ]);



        return view('ativosPorProgramaPos', compact('lava'));
    }

    public function export($format){
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'ativos_por_programa_pós.xlsx'); 
        }
    }

}
