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

        /* Contabiliza aluno grad */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunogr.sql');

        $result = DB::fetch($query);
        $data['Graduação'] = $result['computed'];

        /* Contabiliza aluno pós */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunopos.sql');
        $result = DB::fetch($query);
        $data['Pós-Graduação'] = $result['computed'];

        /* Contabiliza doutorandos ativos */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_aluno_doutorado.sql');
        $result = DB::fetch($query);
        $data['Doutorandos'] = $result['computed'];

        /* Contabiliza pessoa externa à USP/ Unidade */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_externos.sql');
        $result = DB::fetch($query);
        $data['Externos'] = $result['computed'];

        /* Contabiliza alunos cultura e extensão ativos */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunoceu.sql');
        $result = DB::fetch($query);
        $data['Cultura e Extensão'] = $result['computed'];

        /* Contabiliza docentes */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_docentes.sql');
        $result = DB::fetch($query);
        $data['Docentes'] = $result['computed'];

        /* Contabiliza funcionários */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_funcionarios.sql');
        $result = DB::fetch($query);
        $data['Funcionários'] = $result['computed'];

        /* Contabiliza pós doutorandos ativos */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_aluno_pos_doutorado.sql');
        $result = DB::fetch($query);
        $data['Pós-Doutorandos'] = $result['computed'];

        /* Contabiliza estagiários ativos */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_estagiario.sql');
        $result = DB::fetch($query);
        $data['Estagiários'] = $result['computed'];


        $this->data = $data;
    }    
    
    public function grafico(){
    
        $lava_col = new Lavacharts; // See note below for Laravel

        $ativos_col = $lava_col->DataTable();

        /**
         * http://lavacharts.com/api/2.5/Khill/Lavacharts/Formats/NumberFormat.html
         */
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

