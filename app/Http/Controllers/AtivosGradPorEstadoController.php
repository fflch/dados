<?php

namespace App\Http\Controllers;


use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Khill\Lavacharts\Lavacharts;
use Uspdev\Replicado\DB;

class AtivosGradPorEstadoController extends Controller
{
    private $data;
    private $excel;
    public function __construct(Excel $excel){
        $this->excel = $excel;
        
        $data = [];

        $siglas = 
        ['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI', 
        'RJ','RN','RS','RO','RR','SC','SP','SE','TO',
        ];

        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunos_por_estado.sql');

        /* Contabiliza alunos da Graduação, Pós Graduação, Pós Doutorado e Cultura e Extensão
        nascidos no estado escolhido */
        foreach ($siglas as $sigla){
            $query_por_estado = str_replace('__sigla__', $sigla, $query);     
            $result = DB::fetch( $query_por_estado);
            $data[$sigla] = $result['computed'];  
        }            
                
        $this->data = $data;
    }    
    
    public function grafico(){
        $lava = new Lavacharts; // See note below for Laravel

        $alunos = $lava->DataTable();

        $alunos->addStringColumn('City')
                ->addNumberColumn('Alunos');
        
        $alunos_sp = 0;
        foreach($this->data as $key=>$data){
            if($key != 'SP'){
                $alunos->addRow(array('BR-'.$key, $data));
            }else{
                $alunos_sp = $data;
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

        return view('ativosAlunosEstado', compact('lava', 'alunos_sp'));
    }

    public function export($format){
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'alunos_ativos_por_estado.xlsx');
        }
    }
}
