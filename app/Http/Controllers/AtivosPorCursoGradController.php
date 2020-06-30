<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\GenericChart;
use Uspdev\Cache\Cache;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;

class AtivosPorCursoGradController extends Controller
{
    private $data;
    private $excel;
    public function __construct(Excel $excel){
        $this->excel = $excel;
        $cache = new Cache();
        $data = [];

        $cursos = ['8040', '8010', '8021', '8030', '8051'];

        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunogr_curso.sql');
        /* Contabiliza aluno graduação - por curso */
        foreach ($cursos as $curso){
            $query_por_curso = str_replace('__curso__', $curso, $query);
            $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query_por_curso);
            $data[$curso] = $result['computed'];
        } 

        $this->data = $data;
    }    
    
    public function grafico(){
        /* Tipos de gráficos:
         * https://www.highcharts.com/docs/chart-and-series-types/chart-types
         */
        $chart = new GenericChart;
        $chart->labels([
            'Ciências Sociais',
            'Filosofia',
            'Geografia',
            'História',
            'Letras',
        ]);
        $chart->dataset('Quantidade', 'bar', array_values($this->data));

        return view('ativosPCGrad', compact('chart'));
    }

    public function export($format){
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'ativos_por_curso_graduacao.xlsx');
        }
    }
}
