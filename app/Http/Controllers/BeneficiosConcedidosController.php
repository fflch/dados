<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Illuminate\Http\Request;
use Uspdev\Replicado\DB;
use Khill\Lavacharts\Lavacharts;

class BeneficiosConcedidosController extends Controller
{
    private $data;
    private $excel;

    public function __construct(Excel $excel, Request $request)
    {
        $this->excel = $excel;
        $data = [];

        $beneficios = [
            '19' => 'Bolsa Monitoria',
            '22' => 'Programa de Formação de Professores',
            '69' => 'Apoio PAE - Programa de Aperfeiçoamento de Ensino',
            '89' => 'Bolsa Programa Santander Universidades',
            '97' => 'Emergencial - Auxilio Alimentação',
            '99' => 'Auxilio Financeiro',
            '100' => 'Cátedra Olavo Setúbal de Arte, Cultura e Ciência do IEA',
            '103' => 'SEI - Auxilio Alimentação',
            '104' => 'Bolsa InovaGrad'
        ];

        $ano = $request->route()->parameter('ano') ?? '2021';

        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_beneficios.sql');
        foreach($beneficios as $key => $beneficio){
            $query_por_beneficio = str_replace('__beneficio__', $key, $query);
            $query_por_beneficio = str_replace('__ano__', $ano, $query_por_beneficio);
            $result = DB::fetch($query_por_beneficio);
            $data[$beneficio] = $result['computed'];
        }

        $this->data = $data;
    }    
    
    public function grafico($ano){
        $lava = new Lavacharts; 
        $reasons = $lava->DataTable();
        $reasons->addStringColumn('Reasons')
                ->addNumberColumn('Percent');

        foreach($this->data as $key=>$data) {
            $reasons->addRow([$key, (int)$data]);
        }

        $lava->PieChart('Benefícios Concedidos', $reasons, [
            'title'  => "Quantidade de benefícios concedidos em $ano na Faculdade de Filosofia, Letras e Ciências Humanas.",
            'is3D'   => true,
            'height' => 700
        ]);

        $anos = [];
        
        for($year = (int)date("Y"); $year >= 2003; $year--){
            array_push($anos, $year);
        }

        return view('beneficiosConcedidos', compact('ano', 'anos', 'lava'));
    }

    public function export($format, $ano)
    {
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, "beneficios_concedidos_$ano.xlsx"); 
        }
    }
}
