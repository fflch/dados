<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Khill\Lavacharts\Lavacharts;
use Uspdev\Replicado\DB;
class AlunosAtivosGradTipoIngressoController extends Controller
{
    private $data;
    private $excel;
    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
        $data = [];

        // Array com os tipos de ingresso cadastrados no banco dos alunos de graduação. 
        $ingresso = [
                    'Vestibular' => 'Vesitbular',
                    'Vestibular%Lista' => 'Vestibular Lista de espera',
                    '%SISU%' => 'SISU',
                    'Transf USP' => 'Transferência interna USP',
                    'Transf Externa' => 'Transferência externa',
                    'Conv%' => 'Convênio',
                    'Cortesia Diplom%' => 'Cortesia Diplomática',
                    'Liminar' => 'Liminar',
                    'REGULAR' => 'Regular',
                    'processo seletivo' => 'Processo seletivo',
                    'ESPECIAL' => 'ESPECIAL',
                    'Especial' => 'Especial',
                    'anterior a out/2002' => 'Anterior a out/2002',
        ];

        /* Contabiliza alunos da Graduação por tipo de ingresso */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunos_ativos_ingresso.sql');
        foreach ($ingresso as $key => $tipo) {
            $query_por_tipo = str_replace('__tipo__', $key, $query);
            $result = DB::fetch($query_por_tipo);
            $data[$tipo] = $result['computed'];
        }
        $this->data = $data;
    }

    public function grafico()
    {
        $lava = new Lavacharts; 

        $ingresso  = $lava->DataTable();

        $formatter = $lava->NumberFormat([ 
            'pattern' => '#.###',
        ]);
        $ingresso->addStringColumn('Tipo ingresso')
            ->addNumberColumn('Totais de Alunos de Gradução por tipo de ingresso.');
            
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

        return view('ativosAlunosGradTipoIngresso', compact('lava'));
    }

    public function export($format)
    {
        if ($format == 'excel') {
            $export = new DadosExport([$this->data], array_keys($this->data));
            return $this->excel->download($export, 'alunos_ativos_grad_ingresso.xlsx');
        }
    }
}