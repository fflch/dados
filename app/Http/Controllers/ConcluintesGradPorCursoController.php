<?php

namespace App\Http\Controllers;

use App\Charts\GenericChart;
use Uspdev\Cache\Cache;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Illuminate\Http\Request;


class ConcluintesGradPorCursoController extends Controller
{
    private $data;
    private $excel;

    public function __construct(Excel $excel, Request $request)
    {
        $this->excel = $excel;
        $cache = new Cache();
        $data = [];
        $ano = $request->route()->parameter('ano') ?? '2014';
        
        // Array cursos.  
        $cursos = [
            '8040',
            '8010',
            '8021',
            '8030',
            '8050, 8051, 8060',
        ];


        $query = "SELECT COUNT (distinct v.codpes)
        FROM VINCULOPESSOAUSP v
            JOIN TITULOPES t
            ON v.codpes = t.codpes
        WHERE ( v.tipvin = 'ALUNOGR'
            AND v.dtafimvin LIKE '%$ano%'
            AND v.sitoco LIKE 'Conclu%' -- consulta não funciona com acento	
            AND v.codclg = 8
            AND t.codcur IN (__curso__))";


        /* Contabiliza concluintes da graduação em $ano por curso. */
        foreach ($cursos as $curso) {
            $query_por_curso = str_replace('__curso__', $curso, $query);
            $result = $cache->getCached('\Uspdev\Replicado\DB::fetch', $query_por_curso);
            $data[$curso] = $result['computed'];
        }
        $this->data = $data;
        
    }

    public function grafico($ano)
    {
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
        $chart->dataset("Concluintes da Graduação por curso em $ano", 'bar', array_values($this->data));
        
        $anos = [];
        
        
        for($year = (int)date("Y"); $year >= 2000; $year--){
            array_push($anos, $year);
        }


        return view('concluintesGradPorCurso', compact('chart', 'ano', 'anos'));
    }

    public function export($format, $ano)
    {
        if ($format == 'excel') {
            $table = [
                'Ciências Sociais' => $this->data['8040'],
                'Filosofia' => $this->data['8010'],
                'Geografia' => $this->data['8021'],
                'História' => $this->data['8030'],
                'Letras' => $this->data['8050, 8051, 8060']
            ];
            $export = new DadosExport([$table], array_keys($table));
            return $this->excel->download($export, "concluintes_grad_$ano.xlsx");
        }
    }
}