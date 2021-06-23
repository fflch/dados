<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Uspdev\Replicado\DB;
use Khill\Lavacharts\Lavacharts;
class AtivosDocentesPorFuncaoController extends Controller
{
    private $data;
    private $excel;

    public function __construct(Excel $excel){
        $this->excel = $excel;
        
        $data = [];

        $tipos = [
            'Prof Titular' => 'Professores titulares',
            'Prof Doutor' => 'Professores doutores',
            'Prof Associado' => 'Professores associados'
        ];

        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_docentes_funcao.sql');

        foreach ($tipos as $key => $tipo){
            $query_por_funcao = str_replace('__tipo__', $key, $query);
            $result = DB::fetch($query_por_funcao);
            $data[$tipo] = $result['computed'];
        }        

        $this->data = $data;
    }    
    
    public function grafico(){
        $lava = new Lavacharts; // See note below for Laravel

        $ativos  = $lava->DataTable();

        $formatter = $lava->NumberFormat([ 
            'pattern' => '#.###',
        ]);
        $ativos->addStringColumn('Tipo Vínculo')
            ->addNumberColumn('Quantidade de docentes por função');
            
        foreach($this->data as $key=>$data) {
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

        return view('ativosDocentesPorFuncao', compact('lava'));
    }

    public function export($format){
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'docentes_funcao.xlsx');
        }
    }

}
