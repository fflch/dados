<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Uspdev\Replicado\DB;
use App\Utils\Util;
use Khill\Lavacharts\Lavacharts;
class AlunosEspeciaisPosGrDptoController extends Controller
{
    private $data;
    private $excel;

    public function __construct(Excel $excel){
        $this->excel = $excel;
        $data = [];

        $dptos = Util::getAreas();
        /* Contabiliza alunos especiais ativos de pós-graduação, por departamento */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunosposgr_especiais_dpto.sql');
        foreach($dptos as $key => $dpto){
            $query_por_dpto = str_replace('__dpto__', $key, $query);
            $result = DB::fetch($query_por_dpto);
            $data[$dpto] = $result['computed'];
        }

        $this->data = $data;
    }    
    
    public function grafico(){

        $lava = new Lavacharts; 
        $reasons = $lava->DataTable();

        $reasons->addStringColumn('Reasons')
                ->addNumberColumn('Percent');

        foreach($this->data as $key=>$data) {
            $reasons->addRow([$key, (int)$data]);
        }
        
        $lava->PieChart('IMDB', $reasons, [
            'title'  => 'Quantidade de alunos especiais de Pós-Graduação ativos, por departamento, na Faculdade de Filosofia, Letras e Ciências Humanas.',
            'is3D'   => true,
            'height' => 700,

        ]);

        return view('alunosEspeciaisPosGrDpto', compact('lava'));
    }

    public function export($format){
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'alunosEspeciaisPosGrDpto.xlsx'); 
        }
    }
}

