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
    private $curso;

    public function __construct(Excel $excel, Request $request)
    {
        $this->excel = $excel;
        
        $data = [];
        $this->curso = $request->curso ?? 'Letras';
        
        $this->cursos = [
            'Sociais' => ['nome' => 'Ciências Sociais', 'cod' => '8040'],
            'Filosofia' => ['nome' => 'Filosofia', 'cod' => '8010'],
            'Geografia' => ['nome' => 'Geografia', 'cod' => '8021'],
            'Historia' => ['nome' => 'História', 'cod' => '8030'],
            'Letras' => ['nome' => 'Letras', 'cod' => '8050, 8051, 8060']
        ];

        $ano_ini = $request->ano_ini ?? date("Y") - 10;
        $ano_fim = $request->ano_fim ?? date("Y");
        $semestres = [];
        if($ano_ini > $ano_fim){  
            $aux = $ano_fim;
            $ano_fim = $ano_ini;
            $ano_ini = $aux;
        }
        
        for ($i = $ano_ini; $i <= $ano_fim ; $i++) { 
            $semestres[(int)($i . "1")] = "1° semestre - $i";
            $semestres[(int)($i . "2")] = "2° semestre - $i";
        }
        
        $query = "SELECT count (distinct l.codpes)
        FROM LOCALIZAPESSOA l
            JOIN SITALUNOATIVOGR s
            ON s.codpes = l.codpes
            JOIN PESSOA p
            ON p.codpes = l.codpes
        WHERE l.tipvin = 'ALUNOGR'
            AND l.codundclg = 8
            AND s.codcur IN (".$this->cursos[$this->curso]['cod'].")
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

    public function grafico()
    {
        $curso = $this->curso;
        $anos = [];
        
        for($year = (int)date("Y"); $year >= 2000; $year--){
            array_push($anos, $year);
        }

        $cursos = $this->cursos;

        $lava = new Lavacharts; 
        $convenios  = $lava->DataTable();

        $convenios->addStringColumn('Tipo de convênio')
            ->addNumberColumn("Quantidade de trancamentos por semestre no curso de " . $curso);
            
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


        return view('trancamentosCursoPorSemestre', compact('curso', 'cursos', 'lava', 'anos'));
    }

    public function export($format, Request $request)
    {
        if ($format == 'excel') {
            $export = new DadosExport([$this->data], array_keys($this->data));
            return $this->excel->download($export, 'trancamentos_'.strtolower($this->curso).'_semestral.xlsx');
        }
    }
}