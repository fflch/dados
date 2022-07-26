<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Uspdev\Replicado\DB;
use Illuminate\Http\Request;
use Khill\Lavacharts\Lavacharts;
use App\Http\Requests\AlunosAtivosPorCursoRequest;
use App\Http\Controllers\Dados\AlunosAtivosPorCursoDados;

class AlunosAtivosPorCursoController extends Controller
{
    private $data;
    private $excel;
    private $tipvin;

    public function __construct(Excel $excel, AlunosAtivosPorCursoRequest $request){
        $this->excel = $excel;
        $request->validated();
        $tipvin = $request->tipvin ?? 'Não encontrado';
        $this->tipvin = $tipvin;

        $this->data = AlunosAtivosPorCursoDados::listar($request);
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
        $tipvin = $request->tipvin ?? 'Não encontrado';

        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'ativos_'. strtolower($tipvin) .'_curso.xlsx'); 
        }
    }
}
