<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\GenericChart;
use Uspdev\Cache\Cache;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;

class AtivosController extends Controller
{
    private $data;
    private $excel;

    public function __construct(Excel $excel){
        $this->excel = $excel;
        $cache = new Cache();
        $data = [];

        /* Contabiliza aluno grad */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunogr.sql');

        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Graduação'] = $result['computed'];

        /* Contabiliza aluno pós */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunopos.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Pós-Graduação'] = $result['computed'];

        /* Contabiliza alunos cultura e extensão ativos */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunoceu.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Cultura e Extensão'] = $result['computed'];

        /* Contabiliza docentes */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_docentes.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Docentes'] = $result['computed'];

        /* Contabiliza funcionários */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_funcionarios.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Funcionários'] = $result['computed'];

        /* Contabiliza alunos com benefícios ativos */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_beneficiados.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Beneficiados'] = $result['computed'];

        /* Contabiliza estagiários ativos */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_estagiario.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Estagiários'] = $result['computed'];

        $this->data = $data;
    }    
    
    public function grafico(){
        /* Tipos de gráficos:
         * https://www.highcharts.com/docs/chart-and-series-types/chart-types
         */
        $chart = new GenericChart;

        $chart->labels(array_keys($this->data));
        $chart->dataset('Quantidade', 'bar', array_values($this->data));

        return view('ativos', compact('chart'));
    }

    public function export($format)
    {
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'ativos.xlsx'); 
        }
    }
}

