<?php

namespace App\Http\Controllers;

use App\Charts\GenericChart;

use Maatwebsite\Excel\Excel;
use Uspdev\Replicado\DB;
use App\Exports\DadosExport;

class AtivosGradPaisNascimentoController extends Controller
{
    private $data;
    private $excel;
    public function __construct(Excel $excel){
        $this->excel = $excel;

        $data = [];

        /* Contabiliza aluno graduação nascidos no br */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunogr_nascidos_br.sql');
        $result = DB::fetch($query);
        $data['Nascidos no Brasil'] = $result['computed'];

        $this->data = $data;
    }    
    
    public function grafico(){
        /* Tipos de gráficos:
         * https://www.highcharts.com/docs/chart-and-series-types/chart-types
         */
        $chart = new GenericChart;

        $chart->labels(array_keys($this->data));
        $chart->dataset('Quantidade', 'bar', array_values($this->data));

        return view('ativosGradPaisNasc', compact('chart'));
    }

    public function export($format){
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'ativos_graduacao_por_pais_nasc.xlsx');
        }
    }
}
