<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use Uspdev\Replicado\DB;
use App\Exports\DadosExport;
use Illuminate\Http\Request;
use Khill\Lavacharts\Lavacharts;

class ConcluintesPorAnoController extends Controller
{
    private $data;
    private $excel;
    private $vinculo;
    private $nome_vinculo;

    public function __construct(Excel $excel, Request $request)
    {
        $this->excel = $excel;
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

        $vinculos = [
            'ALUNOGR' => 'Aluno de Graduação',
            'ALUNOPOS' => 'Aluno de Pós-Graduação',
        ];

        $this->vinculo = $request->vinculo  ?? 'ALUNOGR';
        $this->nome_vinculo = isset($vinculos[$this->vinculo]) ? $vinculos[$this->vinculo] : '"Vínculo não encontrado"';

        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_concluintes_gr_ano.sql');
        /* Contabiliza concluintes da graduação e da pós-graduação de 2010-2021 */
        foreach ($anos as $ano){
            if($this->vinculo == 'ALUNOPOS'){
                $query = file_get_contents(__DIR__ . '/../../../Queries/conta_concluintes_pos_ano.sql');
            }
            $query_por_ano = str_replace('__ano__', $ano, $query);
            $query_por_ano = str_replace('__vinculo__', $this->vinculo, $query_por_ano);
            $result = DB::fetch($query_por_ano);

            $data[$ano] = $result['computed'];
        }
        
        $this->data = $data;
    }

    public function grafico()
    {
        $anos = [];
        
        for($year = (int)date("Y"); $year >= 2000; $year--){
            array_push($anos, $year);
        }

        $nome_vinculo = $this->nome_vinculo;
        $vinculo = $this->vinculo;

        $lava = new Lavacharts; // See note below for Laravel

        $concluintes = $lava->DataTable();

        $concluintes->addStringColumn('Ano')
                ->addNumberColumn('Concluintes');

        foreach($this->data as $key=>$data) {
            $concluintes->addRow([$key, $data]);
        }
        
        $lava->AreaChart('Concluintes', $concluintes, [
            'title'  => '',
            'legend' => [
                'position' => 'top',
                'alignment' => 'center'  
            ],
            'vAxis' => ['format' => 0],
            'height' => 500,
            'colors' => ['#273e74']
        ]);


        return view('concluintesPorAno', compact( 'vinculo', 'nome_vinculo', 'anos', 'lava'));
    }

    public function export($format, Request $request)
    {
      
        $vinculo = $this->vinculo  ?? 'ALUNOGR';
       

        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'concluintes_'.$vinculo.'_por_ano.xlsx'); 
        }
    }
}
