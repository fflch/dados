<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\GenericChart;
use Uspdev\Cache\Cache;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;

class Beneficios2019PorProgramaController extends Controller
{
    private $data;
    private $excel;

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
        $cache = new Cache();
        $data = [];

        /* Contabiliza benefícios 19 concedidos em 2019 */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_beneficio_19_2019.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['19'] = $result['computed'];


        /* Contabiliza benefícios 22 concedidos em 2019 */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_beneficio_22_2019.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['22'] = $result['computed'];

        
        /* Contabiliza benefícios 69 concedidos em 2019 */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_beneficio_69_2019.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['69'] = $result['computed'];


        /* Contabiliza benefícios 89 concedidos em 2019 */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_beneficio_89_2019.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['89'] = $result['computed'];

        
        /* Contabiliza benefícios 97 concedidos em 2019 */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_beneficio_97_2019.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['97'] = $result['computed'];

        
        /* Contabiliza benefícios 99 concedidos em 2019 */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_beneficio_99_2019.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['99'] = $result['computed'];


        /* Contabiliza benefícios 100 concedidos em 2019 */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_beneficio_100_2019.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['100'] = $result['computed'];


        /* Contabiliza benefícios 103 concedidos em 2019 */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_beneficio_103_2019.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['103'] = $result['computed'];


        /* Contabiliza benefícios 104 concedidos em 2019 */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_beneficio_104_2019.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['104'] = $result['computed'];
        

        $this->data = $data;
    }    
    
    public function grafico(){
        /* Tipos de gráficos:
         * https://www.highcharts.com/docs/chart-and-series-types/chart-types
         */
        $chart = new GenericChart;

        $chart->labels(array_keys($this->data));
        $chart->dataset('Benefícios concedidos em 2019 separados por programa', 'bar', array_values($this->data));

        return view('Benef2019Prog', compact('chart'));
    }

    public function export($format)
    {
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'beneficios_2019_por_programa.xlsx'); 
        }
    }
}
