<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Illuminate\Http\Request;
use Uspdev\Replicado\DB;
use Khill\Lavacharts\Lavacharts;

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
            20141 => '1° semestre - 2014',
            20142 => '2° semestre - 2014',
            20151 => '1° semestre - 2015',
            20152 => '2° semestre - 2015',
            20161 => '1° semestre - 2016',
            20162 => '2° semestre - 2016',
            20171 => '1° semestre - 2017',
            20172 => '2° semestre - 2017',
            20181 => '1° semestre - 2018',
            20182 => '2° semestre - 2018',
            20191 => '1° semestre - 2019',
            20192 => '2° semestre - 2019',
            20201 => '1° semestre - 2020',
            20202 => '2° semestre - 2020',
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
        foreach ($semestres as $key => $semestre) {
            $query_por_semestre = str_replace('__semestre__', $key, $query);
            $result = DB::fetch($query_por_semestre);
            $data[$semestre] = $result['computed'];
        }

        $this->data = $data;
    }

    public function grafico($curso)
    {
        $cursos = $this->cursos;

        $lava = new Lavacharts; 
        $convenios  = $lava->DataTable();

        $convenios->addStringColumn('Tipo de convênio')
            ->addNumberColumn("Quantidade de trancamentos por semestre no curso de $curso");
            
        foreach($this->data as $key=>$data) {
            $convenios->addRow([$key, (int)$data]);
        }


        $max = max($this->data) + 10;
        $div = $max/10;

        $lava->ColumnChart('Convenios', $convenios, [
            'legend' => [
                'position' => 'top',
                
            ],
            'vAxis'=>['ticks'=>range(0,$max, round($div))],
            'height' => 500,
            'colors' => ['#273e74']

        ]);

        return view('trancamentosCursoPorSemestre', compact('curso', 'cursos', 'lava'));
    }

    public function export($format, $curso)
    {
        if ($format == 'excel') {
            $export = new DadosExport([$this->data], array_keys($this->data));
            return $this->excel->download($export, 'trancamentos_'.strtolower($curso).'_semestral.xlsx');
        }
    }
}