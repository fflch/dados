<?php

namespace App\Http\Controllers;

use App\Charts\GenericChart;
use Uspdev\Cache\Cache;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;

class ExAlunosController extends Controller
{
    private $data;
    private $excel;

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
        $cache = new Cache();
        $data = [];    

        /* Contabiliza ex alunos de Graduação e Pós-Graduação (Mestrado e Doutorado). */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_ex_alunosGR.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Graduação'] = $result['computed'];

         /* Contabiliza ex alunos de Graduação e Pós-Graduação (Mestrado e Doutorado). */
         $query = file_get_contents(__DIR__ . '/../../../Queries/conta_ex_alunos_mestrado.sql');
         $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
         $data['Mestrado'] = $result['computed'];

         /* Contabiliza ex alunos de Graduação e Pós-Graduação (Mestrado e Doutorado). */
         $query = file_get_contents(__DIR__ . '/../../../Queries/conta_ex_alunos_doutorado.sql');
         $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
         $data['Doutorado'] = $result['computed'];
       
        $this->data = $data;
    }

    public function grafico()
    {
        $chart = new GenericChart;
        $chart->labels(array_keys($this->data));
        $chart->dataset('Quantidade', 'bar', array_values($this->data));

        return view('exAlunos', compact('chart'));
    }

    public function export($format)
    {
        if ($format == 'excel') {
            $export = new DadosExport([$this->data], array_keys($this->data));
            return $this->excel->download($export, 'ex_alunos_fflch.xlsx');
        }
    }
}