<?php

namespace App\Http\Controllers;

use App\Charts\GenericChart;
use Uspdev\Cache\Cache;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;

class AtivosCeuPaisNascimentoController extends Controller
{
    private $data;
    private $excel;
    public function __construct(Excel $excel){
        $this->excel = $excel;
        $cache = new Cache();
        $data = [];

        /* Contabiliza de cultura e extensão nascidos no br */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunoceu_nascidos_br.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Nascidos no Brasil'] = $result['computed'];

        /* Contabiliza de cultura e extensão não nascido no br */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunoceu_nao_nascidos_br.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Estrangeiros'] = $result['computed'];

        /* Contabiliza de cultura e extensão sem infomações de local de nascimento */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunoceu_nascidos_sem_info.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Sem informações'] = $result['computed'];

        $this->data = $data;
    }    
    
    public function grafico(){
        /* Tipos de gráficos:
         * https://www.highcharts.com/docs/chart-and-series-types/chart-types
         */
        $chart = new GenericChart;

        $chart->labels(array_keys($this->data));
        $chart->dataset('Quantidade', 'bar', array_values($this->data));

        return view('ativosCeuPaisNasc', compact('chart'));
    }

    public function export($format){
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'ativos_ceu_por_pais_nasc.xlsx');
        }
    }
}
