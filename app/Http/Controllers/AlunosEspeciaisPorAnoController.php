<?php

namespace App\Http\Controllers;

use Uspdev\Replicado\DB;
use Maatwebsite\Excel\Excel;
use Illuminate\Http\Request;
use App\Exports\DadosExport;
use Khill\Lavacharts\Lavacharts;

class AlunosEspeciaisPorAnoController extends Controller
{
    private $data;
    private $excel;
    private $vinculo;
    private $nome_vinculo;

    public function __construct(Excel $excel, Request $request){
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
            'ALUNOESPGR' => 'Aluno Especial de Graduação',
            'ALUNOPOSESP' => 'Aluno Especial de Pós-Graduação', 
        ];

        $this->vinculo = $request->vinculo ?? 'ALUNOESPGR';

        $this->nome_vinculo = isset($vinculos[$this->vinculo]) ? $vinculos[$this->vinculo] : '"Vínculo não encontrado"';

        /* Contabiliza alunos especiais de graduação e pós graduação, de 2010 até 2021. */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_aluno_especial.sql');
        foreach($anos as $ano){
            $query_por_ano = str_replace('__ano__', $ano, $query);
            $query_por_ano = str_replace('__aluno__', $this->vinculo, $query_por_ano);
            $result = DB::fetch($query_por_ano);
            $data[$ano] = $result['computed'];
        }

        $this->data = $data;
    }    
    
    public function grafico(){
        
        $vinculo = $this->vinculo;
        $nome_vinculo = $this->nome_vinculo;

        $anos = [];
        
        for($year = (int)date("Y"); $year >= 2000; $year--){
            array_push($anos, $year);
        }

        

        $lava = new Lavacharts; // See note below for Laravel

        $alunos = $lava->DataTable();

        $alunos->addStringColumn('Ano')
                ->addNumberColumn('Quantidade de '.$nome_vinculo.' por ano');

        foreach($this->data as $key=>$data) {
            $alunos->addRow([$key, (int)$data]);
        }
        
        $lava->AreaChart('Alunos', $alunos, [
            'title'  => '',
            'legend' => [
                'position' => 'top',
                'alignment' => 'center'  
            ],
            'vAxis' => ['format' => 0],
            'height' => 500,
            'colors' => ['#273e74']
        ]);


        return view('alunosEspeciaisPorAno', compact('nome_vinculo', 'vinculo', 'anos', 'lava'));
    }

    public function export($format){
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'alunosEspeciaisPorAno.xlsx'); 
        }
    }
}

