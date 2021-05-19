<?php

namespace App\Http\Controllers;

use App\Charts\GenericChart;
use Maatwebsite\Excel\Excel;
use Uspdev\Replicado\DB;
use App\Exports\DadosExport;
use Illuminate\Http\Request;

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

        $anos = ['2010', '2011', '2012', '2013', '2014', '2015', '2016', '2017', '2018', '2019', '2020', '2021'];

        $anos = [];
        
        for($year = (int)date("Y"); $year >= 2000; $year--){
            array_push($anos, $year);
        }

        $vinculos = [
            'ALUNOGR' => 'Aluno de Graduação',
            'ALUNOPOS' => 'Aluno de Pós-Graduação',
        ];

        $this->vinculo = $request->route()->parameter('vinculo') ?? 'ALUNOGR';
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
        $chart = new GenericChart;

        $chart->labels(array_keys($this->data));
        $nome_vinculo = $this->nome_vinculo;
        $vinculo = $this->vinculo;
        $chart->dataset($nome_vinculo.' - Concluintes por ano', 'line', array_values($this->data));

        return view('concluintesPorAno', compact('chart', 'vinculo', 'nome_vinculo'));
    }

    public function export($format, Request $request)
    {
        $vinculo = $request->route()->parameter('vinculo') ?? 'ALUNOGR';
        
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'concluintes_'.$vinculo.'_por_ano.xlsx'); 
        }
    }
}
