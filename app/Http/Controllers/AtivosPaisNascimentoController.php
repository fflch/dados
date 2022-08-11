<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use Uspdev\Replicado\DB;
use App\Exports\DadosExport;
use Illuminate\Http\Request;
use Khill\Lavacharts\Lavacharts;
use App\Http\Requests\AtivosPaisNascimentoRequest;
use App\Http\Controllers\Dados\AtivosPaisNascimentoDados;



class AtivosPaisNascimentoController extends Controller
{
    private $data = [];
    private $excel;

    public function __construct(Excel $excel, AtivosPaisNascimentoRequest $request){
        $this->excel = $excel;
        $this->data = AtivosPaisNascimentoDados::listar($request->validated());
    }

    public function grafico(){

        $vinculo = $this->data['vinculo'];

        $vinculosext = [
            'ALUNOCEU' => 'Alunos de Cultura e Extensão',
            'ALUNOPOS' => 'Alunos de Pós-Graduação',
            'ALUNOGR'  => 'Alunos de Graduação',
            'ALUNOPD'  => 'Alunos de Pós-Doutorado',
            'DOCENTE'  => 'Docentes'
        ];

        $nome_vinculo = isset($vinculosext[$vinculo]) ? $vinculosext[$vinculo] : '"Vínculo não encontrado"';

        $lava = new Lavacharts; // See note below for Laravel

        $ativos  = $lava->DataTable();

        $formatter = $lava->NumberFormat([
            'pattern' => '#.###',
        ]);
        $ativos->addStringColumn('Nacionalidade')
            ->addNumberColumn($nome_vinculo. ' - quantidade');

        foreach($this->data['dados'] as $key=>$data) {
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

        return view('ativosPaisNascimento', compact('vinculo', 'nome_vinculo', 'lava'));
    }

    public function export($format){

        $vinculo = $this->data['vinculo'];

        if($format == 'excel') {
            $export = new DadosExport([$this->data['dados']],array_keys($this->data['dados']));
            return $this->excel->download($export, 'ativos_'.$vinculo.'_nacionalidade.xlsx');
        }
    }
}
