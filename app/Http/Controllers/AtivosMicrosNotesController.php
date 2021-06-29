<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Uspdev\Replicado\DB;
use Khill\Lavacharts\Lavacharts;

class AtivosMicrosNotesController extends Controller
{
    private $data;
    private $excel;

    public function __construct(Excel $excel){
        $this->excel = $excel;
        $data = [];

        /* Contabiliza microcomputadores */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_micros_ativos.sql');
        $result = DB::fetch($query);
        $data['Microcomputadores'] = $result['computed'];

        /* Contabiliza notebooks */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_notes_ativos.sql');
        $result = DB::fetch($query);
        $data['Notebooks'] = $result['computed'];

        $this->data = $data;
    }    
    
    public function grafico(){

        $lava = new Lavacharts; 
        $note_micro  = $lava->DataTable();

        $note_micro->addStringColumn('Tipo de aparelho')
            ->addNumberColumn('Quantidade de microcomputadores e notebooks ativos na Faculdade de Filosofia, Letras e Ciências Humanas.');
            
        foreach($this->data as $key=>$data) {
            $note_micro->addRow([$key, (int)$data]);
        }

        $lava->ColumnChart('MicroNotes', $note_micro, [
            'legend' => [
                'position' => 'top',
                
            ],
            'height' => 500,
            'colors' => ['#273e74']

        ]);

        return view('ativosmicrosnotes', compact('lava'));
    }

    public function export($format){
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'ativos_micros_e_notes.xlsx'); 
        }
    }
}
