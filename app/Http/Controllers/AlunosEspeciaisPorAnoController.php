<?php

namespace App\Http\Controllers;

use App\Charts\GenericChart;
use Uspdev\Replicado\DB;
use Maatwebsite\Excel\Excel;
use Illuminate\Http\Request;
use App\Exports\DadosExport;

class AlunosEspeciaisPorAnoController extends Controller
{
    private $data;
    private $excel;
    private $vinculo;
    private $nome_vinculo;

    public function __construct(Excel $excel, Request $request){
        $this->excel = $excel;

        $data = [];
        $anos = ['2010', '2011', '2012', '2013','2014', '2015', '2016', '2017', '2018', '2019','2020','2021'];

        $vinculos = [
            'ALUNOESPGR' => 'Aluno Especial de Graduação',
            'ALUNOPOSESP' => 'Aluno Especial de Pós-Graduação', 
        ];

        $this->vinculo = $request->route()->parameter('vinculo') ?? 'ALUNOESPGR';

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
        $chart = new GenericChart;

        $chart->labels(array_keys($this->data));
        $vinculo = $this->vinculo;
        $nome_vinculo = $this->nome_vinculo;
        $chart->dataset('Quantidade de '.$nome_vinculo.' por ano', 'line', array_values($this->data));

        return view('alunosEspeciaisPorAno', compact('chart', 'nome_vinculo', 'vinculo'));
    }

    public function export($format){
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'alunosEspeciaisPorAno.xlsx'); 
        }
    }
}

