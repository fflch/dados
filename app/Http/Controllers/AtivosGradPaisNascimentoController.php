<?php

namespace App\Http\Controllers;

use App\Charts\GenericChart;

use Maatwebsite\Excel\Excel;
use Uspdev\Replicado\DB;
use App\Exports\DadosExport;
use Illuminate\Http\Request;

class AtivosGradPaisNascimentoController extends Controller
{
    private $data;
    private $excel;
    private $tipo_vinculo;

    public function __construct(Excel $excel, Request $request){
        $this->excel = $excel;

        $data = [];

        $vinculos = [
            0 => 'Aluno de Cultura e Extensão',
            1 => 'Aluno de Pós-Graduação',
            2 => 'Aluno de Graduação',
            3 => 'Pós-doutorando',
            4 => 'Docente'
        ];

        $this->tipo_vinculo = $request->route()->parameter('tipo_vinculo') ?? 0;

        /* Contabiliza alunos nascidos e não nascidos no BR */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunogr_nascidos_br.sql');
        foreach ($vinculos as $vinculo){
            $query_por_vinculo = str_replace('__vinculo__', $vinculo, $query);

            $result = DB::fetch($query_por_vinculo);

            $data[$vinculo] = $result['computed'];    
        }

        $this->data = $data;
    }    
    
    public function grafico(){
        $chart = new GenericChart;

        $chart->labels(array_keys($this->data));

        $tipo_vinculo = $this->tipo_vinculo;

        $chart->dataset('Quantidade', 'bar', array_values($this->data));

        return view('ativosPaisNasc', compact('chart', 'tipo_vinculo'));
    }

    public function export($format){
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'ativos_graduacao_por_pais_nasc.xlsx');
        }
    }
}
