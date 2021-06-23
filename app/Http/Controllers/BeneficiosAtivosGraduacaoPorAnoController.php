<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Khill\Lavacharts\Lavacharts;
use Uspdev\Replicado\DB;
use Illuminate\Http\Request;

class BeneficiosAtivosGraduacaoPorAnoController extends Controller
{
    private $data;
    private $excel;
    public function __construct(Excel $excel,  Request $request)
    {
   
        $ano = $request->route()->parameter('ano') ??  date("Y") - 1;
        $ano = $ano.", ".$ano."1, ".$ano."2";

        $this->excel = $excel;
        $data = [];

        // Array com cód. dos benefícios oferecidos em 2020 (1º e 2º semestres) da graduação. 
        $beneficio = [
                    2,
                    5,
                    52,
                    102,
        ];

        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_beneficiosAtivos_graduacao_por_ano.sql');
        $query = str_replace('__ano__', $ano, $query);
        
        /* Contabiliza alunos da Graduação por tipo de beneficio */
        foreach ($beneficio as $codigo) {
            $query_por_codigo = str_replace('__codigo__', $codigo, $query);
            $result = DB::fetch($query_por_codigo);
            $data[$codigo] = $result['computed'];
        }
        $this->data = $data;
    }

    public function grafico( Request $request)
    {
        $ano = $request->route()->parameter('ano') ??  date("Y") - 1;

        $anos = [];
        
        for($year = (int)date("Y"); $year >= 2000; $year--){
            array_push($anos, $year);
        }

        $labels = [
            2 => 'Auxílio Alimentação',
            5 => 'Auxílio Moradia',
            52 => 'Bolsa PEEG',
            102 => 'SEI - Auxílio Financeiro',
        ];
        $lava = new Lavacharts; // See note below for Laravel

        $beneficios  = $lava->DataTable();
        $beneficios->addStringColumn('Benefício')
            ->addNumberColumn('Quantidade');
            
        foreach($labels as $key=>$label){ 
            $beneficios->addRow([$label, $this->data[$key]]);
        }
        $lava->ColumnChart('Beneficios', $beneficios, [
            'legend' => [
                'position' => 'top',
                'alignment' => 'center',
                
            ],
            'height' => 500,
            'vAxis' => ['format' => 0],
            'colors' => ['#273e74']

        ]);


        return view('beneficiosAtivosGraduacaoPorAno', compact('lava', 'anos', 'ano'));
    }

    public function export($format,  Request $request)
    {
        $ano = $request->route()->parameter('ano') ??  date("Y") - 1;

        $labels = [
            'Auxílio Alimentação',
            'Auxílio Moradia',
            'Bolsa PEEG',
            'SEI - Auxílio Financeiro',
        ];

        if ($format == 'excel') {
            $export = new DadosExport([$this->data], $labels);
            return $this->excel->download($export, 'beneficios_ativos_graduacao_'.$ano.'.xlsx');
        }
    }
}