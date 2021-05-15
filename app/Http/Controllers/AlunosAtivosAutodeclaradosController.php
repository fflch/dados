<?php

namespace App\Http\Controllers;

use App\Charts\GenericChart;
use Maatwebsite\Excel\Excel;
use Illuminate\Http\Request;
use App\Utils\Util;
use App\Exports\DadosExport;
use Uspdev\Replicado\DB;

class AlunosAtivosAutodeclaradosController extends Controller
{
    private $data;
    private $excel;
    private $vinculo;
    
    public function __construct(Excel $excel,Request $request)
    {
        $this->excel = $excel;
        $data = [];

        //tipo de vínculo
        $vinculos = ['ALUNOGR', 'ALUNOPOS', 'ALUNOCEU', 'ALUNOPD'];

        $vinculos = $request->route()->parameter('vinculo') ?? 'ALUNOGR';

        $cores = Util::racas;

        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunos_autodeclarados.sql');
        foreach ($cores as $cor) {
            $query_por_cor = str_replace('__cor__', $cor, $query);

            $query_por_cor = str_replace('__vinculo__', $vinculos, $query_por_cor);

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
        $vinculos = $this->vinculo;
        $cores = Util::racas;

        $chart->dataset('Quantidade', 'bar', array_values($this->data));

        return view('ativosAlunosAutodeclarados', compact('chart', 'vinculos', 'cores'));
    }

    public function export($format)
    {
        if ($format == 'excel') {
            $export = new DadosExport([$this->data], array_keys($this->data));
            return $this->excel->download($export, 'ativos_autodeclarados.xlsx');
        }
    }
}
