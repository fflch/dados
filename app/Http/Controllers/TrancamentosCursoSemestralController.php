<?php

namespace App\Http\Controllers;

use App\Charts\GenericChart;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Illuminate\Http\Request;
use Uspdev\Replicado\DB;

class TrancamentosCursoSemestralController extends Controller
{
    private $data;
    private $excel;
    private $cursos;

    public function __construct(Excel $excel, Request $request)
    {
        $this->excel = $excel;
        
        $data = [];
        $curso = $request->route()->parameter('curso') ?? 'Letras';
        $this->cursos = [
            'Sociais' => ['nome' => 'Ciências Sociais', 'cod' => '8040'],
            'Filosofia' => ['nome' => 'Filosofia', 'cod' => '8010'],
            'Geografia' => ['nome' => 'Geografia', 'cod' => '8021'],
            'Historia' => ['nome' => 'História', 'cod' => '8030'],
            'Letras' => ['nome' => 'Letras', 'cod' => '8050, 8051, 8060']
        ];
        // Array com os totais de trancamentos por semestre. 
        $semestres = [
            20141,
            20142,
            20151,
            20152,
            20161,
            20162,
            20171,
            20172,
            20181,
            20182,
            20191,
            20192,
            20201,
            20202,
        ];


        $query = "SELECT count (distinct l.codpes)
        FROM LOCALIZAPESSOA l
            JOIN SITALUNOATIVOGR s
            ON s.codpes = l.codpes
            JOIN PESSOA p
            ON p.codpes = l.codpes
        WHERE l.tipvin = 'ALUNOGR'
            AND l.codundclg = 8
            AND s.codcur IN (".$this->cursos[$curso]['cod'].")
            AND s.staalu = 'T'
            AND s.anosem = __semestre__";

        
        /* Contabiliza trancamentos por semestre. */
        foreach ($semestres as $semestre) {
            $query_por_semestre = str_replace('__semestre__', $semestre, $query);
            $result = DB::fetch($query_por_semestre);
            $data[$semestre] = $result['computed'];
        }
       

        $this->data = $data;
    }

    public function grafico($curso)
    {
        $cursos = $this->cursos;
        /* Tipos de gráficos:
         * https://www.highcharts.com/docs/chart-and-series-types/chart-types
         */
        $chart = new GenericChart;
        $chart->labels([
            '1° semestre - 2014',
            '2° semestre - 2014',
            '1° semestre - 2015',
            '2° semestre - 2015',
            '1° semestre - 2016',
            '2° semestre - 2016',
            '1° semestre - 2017',
            '2° semestre - 2017',
            '1° semestre - 2018',
            '2° semestre - 2018',
            '1° semestre - 2019',
            '2° semestre - 2019',
            '1° semestre - 2020',
            '2° semestre - 2020',
        ]);
        $chart->dataset('Quantidade', 'bar', array_values($this->data));

        return view('trancamentosCursoPorSemestre', compact('chart', 'curso', 'cursos'));
    }

    public function export($format, $curso)
    {
        if ($format == 'excel') {
            $export = new DadosExport([$this->data], array_keys($this->data));
            return $this->excel->download($export, 'trancamentos_'.strtolower($curso).'_semestral.xlsx');
        }
    }
}