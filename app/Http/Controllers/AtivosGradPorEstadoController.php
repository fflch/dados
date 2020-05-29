<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\GenericChart;
use Uspdev\Cache\Cache;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;

class AtivosGradPorEstadoController extends Controller
{
    private $data;
    private $excel;
    public function __construct(Excel $excel){
        $this->excel = $excel;
        $cache = new Cache();
        $data = [];

        $siglas = 
        ['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI', 
        'RJ','RN','RS','RO','RR','SC','SP','SE','TO',
        ];

        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunos_por_estado.sql');

        /* Contabiliza alunos da Graduação, Pós Graduação, Pós Doutorado e Cultura e Extensão
        nascidos no estado escolhido */
        foreach ($siglas as $sigla){
            $query_por_estado = str_replace('__sigla__', $sigla, $query);     
            $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query_por_estado);
            $data[$sigla] = $result['computed'];  
        }            
                
        $this->data = $data;
    }    
    
    public function grafico(){
        /* Tipos de gráficos:
         * https://www.highcharts.com/docs/chart-and-series-types/chart-types
         */
        $chart = new GenericChart;

        $chart->labels(array_keys($this->data));
        $chart->dataset('Quantidade', 'pie', array_values($this->data));

        return view('ativosAlunosEstado', compact('chart'));
    }

    public function export($format){
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'alunos_ativos_por_estado.xlsx');
        }
    }
}
