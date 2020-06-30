<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\GenericChart;
use Uspdev\Cache\Cache;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;

class AtivosPorGeneroCursoGradFilosofiaController extends Controller
{
    private $data;
    private $excel;

    public function __construct(Excel $excel){
        $this->excel = $excel;
        $cache = new Cache();
        $data = [];
        $siglas = ['F', 'M'];

        /* Contabiliza alunos graduação gênero - filosofia */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunogr_filosofia_genero.sql');
        foreach($siglas as $sigla){
            $query_por_genero = str_replace('__sigla__', $sigla, $query);
            $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query_por_genero);
            $data[$sigla] = $result['computed'];
        }

        $this->data = $data;
    }    
    
    public function grafico(){
        /* Tipos de gráficos:
         * https://www.highcharts.com/docs/chart-and-series-types/chart-types
         */
        $chart = new GenericChart;
        $chart->labels([
            'Feminino',
            'Masculino',
        ]);
        $chart->dataset('Filosofia por Gênero', 'bar', array_values($this->data));

        return view('ativosGradFilosofia', compact('chart'));
    }

    public function export($format)
    {
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'ativos_grad_genero_filosofia.xlsx'); 
        }
    }
}
