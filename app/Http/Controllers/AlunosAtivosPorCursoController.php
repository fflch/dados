<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Uspdev\Replicado\DB;
use Illuminate\Http\Request;
use Khill\Lavacharts\Lavacharts;
class AlunosAtivosPorCursoController extends Controller
{
    private $data;
    private $excel;
    private $tipvin;

    public function __construct(Excel $excel, Request $request){
        $this->excel = $excel;
        $data = [];

        $tipvin = $request->route()->parameter('tipvin') ?? 'Não encontrado';
        $this->tipvin = $tipvin;
        $cursos = [
            8040 => ['nome' => 'Ciências Sociais', 'codsetprj' => [591, 602, 604]],
            8010 => ['nome' => 'Filosofia', 'codsetprj' => [594]],
            8021 => ['nome' => 'Geografia', 'codsetprj' => [596]],
            8030 => ['nome' => 'História', 'codsetprj' => [598]],
            8051 => ['nome' => 'Letras', 'codsetprj' => [592, 599, 600, 601, 603]],
        ];

        if($tipvin == 'ALUNOGR'){
            $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunogr_curso.sql');
            foreach ($cursos as $key=>$value){
                $query_por_curso = str_replace('__curso__', $key, $query);
                $result = DB::fetch($query_por_curso);
                $data[$value['nome']] = $result['computed'];
            } 
           
        }else if($tipvin == 'ALUNOPD'){
            $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunoposdoutorado_curso.sql');
            foreach( $cursos as $key=>$value){
                $query_curso = str_replace('__codsetprj__', implode (", ", $value['codsetprj']) , $query);
                $result = DB::fetch($query_curso);
                $data[$value['nome']] = $result['computed'];
            }
        }

        $this->data = $data;
    }

    public function grafico(){

        $lava = new Lavacharts; 

        $cursos  = $lava->DataTable();

        $cursos->addStringColumn('Cursos')
            ->addNumberColumn('Quantidade');
            
        foreach($this->data as $key=>$data) {
            $cursos->addRow([$key, (int)$data]);
        }

        $lava->ColumnChart('Ativos por curso', $cursos, [
            'legend' => [
                'position' => 'top',
                
            ],
            'height' => 500,
            'colors' => ['#273e74']

        ]);

        $tipvin = $this->tipvin;
        if($tipvin == 'ALUNOGR'){
            $texto =  'Quantidade de alunos da graduação ativos na Faculdade de Filosofia, Letras e Ciências Humanas separados por curso.';
           
        }else if($tipvin == 'ALUNOPD'){
            $texto = 'Quantidade de Pós-doutorando com programa ativo na Faculdade de Filosofia, Letras e Ciências Humanas separados por curso.';
        }

        return view('alunosAtivosPorCurso', compact('texto', 'tipvin', 'lava'));
    }

    public function export($format, Request $request){
        $tipvin = $request->route()->parameter('tipvin') ?? 'Não encontrado';

        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'ativos_'. strtolower($tipvin) .'_curso.xlsx'); 
        }
    }
}
