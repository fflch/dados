<?php

namespace App\Http\Controllers;

use Uspdev\Replicado\DB;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Khill\Lavacharts\Lavacharts;
use Illuminate\Http\Request;

class BeneficiosConcedidosHistoricoController extends Controller
{
    private $data;
    private $excel;

    public function __construct(Excel $excel, Request $request){
        $this->excel = $excel;
       
       
        $ano_ini = $request->ano_ini ?? date("Y") - 5;
        $ano_fim = $request->ano_fim ?? date("Y");

        if($ano_ini > $ano_fim){ 
            $aux = $ano_fim;
            $ano_fim = $ano_ini;
            $ano_ini = $aux;
        }
        $data = [];

        $anos = [];
        for ($i = $ano_ini; $i <= $ano_fim ; $i++) { 
            array_push($anos,(int) $i);
        }
            

        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_beneficios_ano.sql');
        /* Contabiliza benefícios concedidos de 2014-2020 */
        foreach($anos as $ano){
            $query_por_ano = str_replace('__ano__', $ano, $query);
            $result = DB::fetch($query_por_ano);
            $data[$ano] = $result['computed'];
        }        

        $this->data = $data;
    }    
    
    public function grafico(){

        $anos = [];
        
        for($year = (int)date("Y"); $year >= 2000; $year--){
            array_push($anos, $year);
        }

        $lava = new Lavacharts; // See note below for Laravel

        $ativos = $lava->DataTable();

        $ativos->addStringColumn('Ano')
                ->addNumberColumn('Benefícios concedidos por ano');

        foreach($this->data as $key=>$data) {
            $ativos->addRow([$key, (int)$data]);
        }
        
        $lava->AreaChart('Beneficios', $ativos, [
            'title'  => '',
            'legend' => [
                'position' => 'top',
                'alignment' => 'center'  
            ],
            'vAxis' => ['format' => 0],
            'height' => 500,
            'colors' => ['#273e74']
        ]);

        return view('ativosBeneficiosConHist', compact('lava', 'anos'));
    }

    public function export( $format)
    {

        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'historico_beneficios_concedidos.xlsx'); 
        }
    }
}
