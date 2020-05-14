<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\GenericChart;
use Uspdev\Cache\Cache;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;

class AtivosBeneficiosController extends Controller
{
    private $data;
    private $excel;

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
        $cache = new Cache();
        $data = [];

        /* Contabiliza alunos com beneficios ativos de 2010-2020 */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_beneficiados_2010.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['2010'] = $result['computed'];

        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_beneficiados_2011.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['2011'] = $result['computed'];

        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_beneficiados_2012.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['2012'] = $result['computed'];

        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_beneficiados_2013.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['2013'] = $result['computed'];

        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_beneficiados_2014.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['2014'] = $result['computed'];

        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_beneficiados_2015.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['2015'] = $result['computed'];

        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_beneficiados_2016.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['2016'] = $result['computed'];

        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_beneficiados_2017.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['2017'] = $result['computed'];

        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_beneficiados_2018.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['2018'] = $result['computed'];

        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_beneficiados_2019.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['2019'] = $result['computed'];

        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_beneficiados_2020.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['2020'] = $result['computed'];

        $this->data = $data;
    }    
    
    public function grafico(){
        /* Tipos de gráficos:
         * https://www.highcharts.com/docs/chart-and-series-types/chart-types
         */
        $chart = new GenericChart;

        $chart->labels(array_keys($this->data));
        $chart->dataset('Quantidade de pessoas com benefícios', 'bar', array_values($this->data));

        return view('ativosBeneficios', compact('chart'));
    }

    public function export($format)
    {
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'ativos_beneficios.xlsx'); 
        }
    }
}
