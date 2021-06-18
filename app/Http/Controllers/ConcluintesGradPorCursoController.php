<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Illuminate\Http\Request;
use Khill\Lavacharts\Lavacharts;
use Uspdev\Replicado\DB;


class ConcluintesGradPorCursoController extends Controller
{
    private $data;
    private $excel;

    public function __construct(Excel $excel, Request $request)
    {
        $this->excel = $excel;
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
            $result = DB::fetch($query_por_curso);
            $data[$curso] = $result['computed'];
        }
        $this->data = $data;
        
    }

    public function grafico($ano)
    {
        $anos = [];
        
        for($year = (int)date("Y"); $year >= 2000; $year--){
            array_push($anos, $year);
        }

        $labels = [
            'Ciências Sociais' => '8040',
            'Filosofia' => '8010',
            'Geografia' => '8021',
            'História' => '8030',
            'Letras' => '8050, 8051, 8060',
        ];


        $lava = new Lavacharts; // See note below for Laravel

        $concluintes  = $lava->DataTable();
        $concluintes->addStringColumn('Curso')
            ->addNumberColumn('Quantidade');
            
        foreach($labels as $key=>$label){ 
            $concluintes->addRow([$key, $this->data[$label]]);
        }


        $lava->ColumnChart('Concluintes', $concluintes, [
            'legend' => [
                'position' => 'top',
                ' alignment' => 'center',
                
            ],
            'height' => 500,
            'vAxis' => ['format' => 0],
            'colors' => ['#273e74']

        ]);


        return view('concluintesGradPorCurso', compact('ano', 'anos', 'lava'));
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