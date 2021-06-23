<?php

namespace App\Http\Controllers;

use Uspdev\Cache\Cache;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Illuminate\Http\Request;
use Khill\Lavacharts\Lavacharts;

class BeneficiadosController extends Controller
{
    private $data;
    private $excel;

    public function __construct(Excel $excel, Request $request)
    {
        $this->excel = $excel;
        $cache = new Cache();
        $data = [];

        $anos = [];

        $ano_ini = $request->ano_ini ?? date("Y") - 5;
        $ano_fim = $request->ano_fim ?? date("Y");

        if($ano_ini > $ano_fim){ 
            $aux = $ano_fim;
            $ano_fim = $ano_ini;
            $ano_ini = $aux;
        }
        
        for ($i = $ano_ini; $i <= $ano_fim ; $i++) { 
            array_push($anos,(int) $i);
        }

        /* Contabiliza alunos com beneficios ativos por ano */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_beneficiados_ano.sql');
        foreach($anos as $ano){
            $query_por_ano = str_replace('__ano__', $ano, $query);
            $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query_por_ano);
            $data[$ano] = $result['computed'];
        }

        $this->data = $data;
    }    
    
    public function grafico(Request $request){
        $anos = [];
        
        for($year = (int)date("Y"); $year >= 2000; $year--){
            array_push($anos, $year);
        }

        $lava = new Lavacharts;

        $beneficiados = $lava->DataTable();

        $beneficiados->addStringColumn('Ano')
                ->addNumberColumn('Quantidade de alunos com benefícios');

        foreach($this->data as $key=>$data) {
            $beneficiados->addRow([$key, $data]);
        }
        
        $lava->AreaChart('Beneficiados', $beneficiados, [
            'title'  => "Série histórica: quantidade de alunos com algum tipo de benefício na Faculdade de Filosofia, Letras e Ciências Humanas entre $request->ano_ini - $request->ano_fim.",
            'legend' => [
                'position' => 'top',
                'alignment' => 'center'  
            ],
            'vAxis' => ['format' => 0],
            'height' => 500,
            'colors' => ['#273e74']
        ]);

        return view('beneficiados', compact('lava', 'anos'));
    }

    public function export($format)
    {
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'ativos_beneficios.xlsx'); 
        }
    }
}
