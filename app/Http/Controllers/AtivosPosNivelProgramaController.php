<?php

namespace App\Http\Controllers;

use App\Charts\GenericChart;
use Uspdev\Cache\Cache;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;

class AtivosPosNivelProgramaController extends Controller
{
    private $data;
    private $excel;

    public function __construct(Excel $excel){
        $this->excel = $excel;
        $cache = new Cache();
        $data = [];

        $niveis = ['ME', 'DD', 'DO'];

        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunospos_nivelpgm.sql');
        /* Contabiliza alunos ativos da pós gradruação por nível do programa (Mestrado, Doutorado Direto e Doutorado) */
        foreach($niveis as $nivel)
        {
            $query_por_nivel = str_replace('__nivel__', $nivel, $query);
            $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query_por_nivel);
            $data[$nivel] = $result['computed'];
        }

        $this->data = $data;
    }

    public function grafico(){
        $chart = new GenericChart;

        $chart->labels([
            'Mestrado',
            'Doutorado Direto',
            'Doutorado'
        ]);
        $chart->dataset('Quantidade', 'bar', array_values($this->data));

        return view('ativosPosNivelPgm', compact('chart'));
    }

    public function export($format){
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'ativos_pos_nivelpgm.xlsx'); 
        }
    }
}
