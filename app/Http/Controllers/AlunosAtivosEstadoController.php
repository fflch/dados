<?php

namespace App\Http\Controllers;


use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Khill\Lavacharts\Lavacharts;
use Uspdev\Replicado\DB;
use App\Http\Controllers\Dados\AlunosAtivosEstadoDados;

class AlunosAtivosEstadoController extends Controller
{
    private $excel;

    public function __construct(Excel $excel){
        $this->excel = $excel;              
        $this->data = AlunosAtivosEstadoDados::listar();
    }    
    
    public function grafico(){
        $lava = new Lavacharts; // See note below for Laravel

        $alunos = $lava->DataTable();

        $alunos->addStringColumn('Estado')
                ->addNumberColumn('Alunos');

        $alunos_sp = 0;
        foreach($this->data as $key=>$value){
            if($key != 'SP'){
                $alunos->addRow(array('BR-'.$key, $value));
            }else{
                $alunos_sp = $value;
            }
        }

        $lava->GeoChart('Alunos', $alunos, [
            'title'  => '',
            'region' =>  'BR',
            'resolution' => 'provinces',
            'height' => 500,
            'legend' => [
                'position' => 'bottom',
                'alignment' => 'center'  
            ],
        ]);

        return view('alunosAtivosEstado', compact('lava', 'alunos_sp'));
    }
 
    public function export($format){
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'alunos_ativos_por_estado.xlsx');
        }
    }
}
