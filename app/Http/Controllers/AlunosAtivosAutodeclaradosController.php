<?php

namespace App\Http\Controllers;

use App\Charts\GenericChart;
use Maatwebsite\Excel\Excel;
use Illuminate\Http\Request;
use App\Utils\Util;
use App\Exports\DadosExport;
use Uspdev\Replicado\DB;
use Uspdev\Replicado\Uteis;
class AlunosAtivosAutodeclaradosController extends Controller
{
    private $data;
    private $excel;
    private $vinculo;
    private $nome_vinculo;
    
    public function __construct(Excel $excel,Request $request)
    {
        $this->excel = $excel;
        $data = [];

        $vinculos = [
            'ALUNOGR' => 'Aluno de Graduação', 
            'ALUNOPOS' => 'Aluno de Pós-Graduação', 
            'ALUNOCEU' => 'Aluno de Cultura e Extensão', 
            'ALUNOPD' => 'Aluno de Pós-Doutorado'
        ];

        $this->vinculo = $request->route()->parameter('vinculo') ?? 'ALUNOGR';

        $cores = Util::racas;

        $this->nome_vinculo = isset($vinculos[$this->vinculo]) ? $vinculos[$this->vinculo] : '"Vínculo não encontrado"';

        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunos_autodeclarados.sql');
        foreach ($cores as $cor) {
            $query_por_cor = str_replace('__cor__', $cor, $query);

            $query_por_cor = str_replace('__vinculo__', $this->vinculo, $query_por_cor);

            $result = DB::fetch($query_por_cor);
            $data[$cor] = $result['computed'];
        }
        $this->data = $data;
    }

    public function grafico()
    {
        $chart = new GenericChart;
        $chart->labels([
            'Indígena',
            'Branca',
            'Preta/Negra',
            'Amarela',
            'Parda',
            'Não informado',
        ]);
        $vinculo = $this->vinculo;
        $cores = Util::racas;
        $nome_vinculo = $this->nome_vinculo;

        $chart->dataset($nome_vinculo .' - quantidade', 'bar', array_values($this->data));

        return view('ativosAlunosAutodeclarados', compact('chart', 'vinculo', 'cores', 'nome_vinculo'));
    }

    public function export($format, Request $request)
    {
        $vinculo = $request->route()->parameter('vinculo') ?? 'ALUNOGR';
        
        $nome_vinculo = isset($vinculos[$vinculo]) ? $vinculos[$vinculo] : 'Vínculo não encontrado';
    
        $nome_vinculo = str_replace(' ','_', Uteis::removeAcentos(strtolower($nome_vinculo)));

        if ($format == 'excel') {
            $export = new DadosExport([$this->data], ['Indígena',
            'Branca',
            'Preta/Negra',
            'Amarela',
            'Parda',
            'Não informado']);
            return $this->excel->download($export, 'ativos_'.$vinculo.'_autodeclarados.xlsx');
        }
    }
}
