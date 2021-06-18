<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Uspdev\Replicado\DB;
use Khill\Lavacharts\Lavacharts;
class AtivosPosNivelProgramaController extends Controller
{
    private $data;
    private $excel;

    public function __construct(Excel $excel){
        $this->excel = $excel;
        $data = [];

        $niveis = [
            'ME' => 'Mestrado',
            'DD' => 'Doutorado Direto',
            'DO' => 'Doutorado'
        ];

        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunospos_nivelpgm.sql');
        /* Contabiliza alunos ativos da pós gradruação por nível do programa (Mestrado, Doutorado Direto e Doutorado) */
        foreach($niveis as $key => $nivel)
        {
            $query_por_nivel = str_replace('__nivel__', $key, $query);
            $result = DB::fetch($query_por_nivel);
            $data[$nivel] = $result['computed'];
        }

        $this->data = $data;
    }

    public function grafico(){

        $lava = new Lavacharts; 

        $cursos  = $lava->DataTable();

        $cursos->addStringColumn('Cursos')
            ->addNumberColumn('Quantidade de alunos');
            
        foreach($this->data as $key=>$data) {
            $cursos->addRow([$key, (int)$data]);
        }

        $lava->ColumnChart('Ativos Pós-Graduação', $cursos, [
            'legend' => [
                'position' => 'top',
                
            ],
            'height' => 500,
            'colors' => ['#273e74']

        ]);

        return view('ativosPosNivelPgm', compact('lava'));
    }

    public function export($format){
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'ativos_pos_nivelpgm.xlsx'); 
        }
    }
}
