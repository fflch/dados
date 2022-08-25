<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Khill\Lavacharts\Lavacharts;
use Uspdev\Replicado\DB;
use App\Http\Controllers\Dados\AlunosAtivosGradTipoIngressoDados;

class AlunosAtivosGradTipoIngressoController extends Controller
{
    private $data;
    private $excel;
    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
        $this->data = AlunosAtivosGradTipoIngressoDados::listar();
    }

    public function grafico()
    {
        $lava = new Lavacharts; 

        $ingresso  = $lava->DataTable();

        $formatter = $lava->NumberFormat([ 
            'pattern' => '#.###',
        ]);
        $ingresso->addStringColumn('Tipo ingresso')
            ->addNumberColumn('Totais de graduandos ativos por tipo de ingresso');
            
        foreach($this->data as $key=>$data) {
            $ingresso->addRow([$key, $data]);
        }

        $lava->ColumnChart('Ingresso', $ingresso, [
            'legend' => [
                'position' => 'top',
                'alignment' => 'center',
                
            ],
            'height' => 500,
            'vAxis' => ['format' => 0],
            'colors' => ['#273e74']

        ]);

        return view('alunosAtivosGradTipoIngresso', compact('lava'));
    }

    public function export($format)
    {
        if ($format == 'excel') {
            $export = new DadosExport([$this->data], array_keys($this->data));
            return $this->excel->download($export, 'alunos_ativos_grad_ingresso.xlsx');
        }
    }
}