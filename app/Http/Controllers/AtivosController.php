<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Khill\Lavacharts\Lavacharts;
use Uspdev\Replicado\DB;

class AtivosController extends Controller
{
    private $data;
    private $excel;

    public function __construct(Excel $excel){
        $this->excel = $excel;
        $data = [];

        /* Contabiliza alunos grad, pós, cultura e extensão e estagiários */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunogr_ceu_pos_estagiarios.sql');
        
        $vinculos = [
            'ALUNOGR' => 'Graduação',
            'ALUNOPOS' => 'Pós-Graduação',
            'ALUNOCEU' => 'Cultura e Extensão',
            'ESTAGIARIORH' => 'Estagiários'
        ];

        foreach($vinculos as $vinculo=>$key){
            $query_por_vinculo = str_replace('__tipo__',$vinculo, $query);
            $result = DB::fetch($query_por_vinculo);
            $data[$key] = $result['computed'];
        }

        /* Contabiliza docentes e funcionários */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_docentes_funcionarios.sql');
        $servidores = [
            'Docente' => 'Docentes',
            'Servidor' => 'Funcionários'
        ];

        foreach($servidores as $servidor=>$key){
            $query_por_vinculo = str_replace('__tipo__', $servidor, $query);
            $result = DB::fetch($query_por_vinculo);
            $data[$key] = $result['computed'];
        }

        /* Contabiliza doutorandos ativos */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_aluno_doutorado.sql');
        $result = DB::fetch($query);
        $data['Doutorandos'] = $result['computed'];

        /* Contabiliza pessoa externa à USP/ Unidade */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_externos.sql');
        $result = DB::fetch($query);
        $data['Externos'] = $result['computed'];

        /* Contabiliza pós doutorandos ativos */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_aluno_pos_doutorado.sql');
        $result = DB::fetch($query);
        $data['Pós-Doutorandos'] = $result['computed'];

        $this->data = $data;
    }    
    
    public function grafico(){
    
        $lava_col = new Lavacharts; 

        $ativos_col = $lava_col->DataTable();
        
        $formatter = $lava_col->NumberFormat([ 
            'pattern' => '#.###',
        ]);
       
        $ativos_col->addStringColumn('Tipo Vínculo')
                ->addNumberColumn('Quantidade', $formatter);

        foreach($this->data as $key=>$data) {
            $ativos_col->addRow([$key, (int)$data]);
        }
        
        $lava_col->ColumnChart('AtivosCOL', $ativos_col, [
            'legend' => [
                'position' => 'top',
                
            ],
            'titlePosition' => 'out',
            'height' => 500,
            'colors' => ['#273e74']

        ]);

        return view('ativos', compact('lava_col'));
    }

    public function export($format){
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'ativos.xlsx'); 
        }
    }
}

