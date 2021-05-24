<?php

namespace App\Http\Controllers;

use App\Charts\GenericChart;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Illuminate\Http\Request;
use Uspdev\Replicado\DB;
use App\Utils\Util;

class ExAlunosController extends Controller
{
    private $data;
    private $excel;

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
        $data = [];    

        /* Contabiliza ex alunos de Graduação e Pós-Graduação (Mestrado e Doutorado). */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_ex_alunosGR.sql');
        $result = DB::fetch($query);
        $data['Graduação'] = $result['computed'];

         /* Contabiliza ex alunos de Graduação e Pós-Graduação (Mestrado e Doutorado). */
         $query = file_get_contents(__DIR__ . '/../../../Queries/conta_ex_alunos_mestrado.sql');
         $result = DB::fetch($query);
         $data['Mestrado'] = $result['computed'];

         /* Contabiliza ex alunos de Graduação e Pós-Graduação (Mestrado e Doutorado). */
         $query = file_get_contents(__DIR__ . '/../../../Queries/conta_ex_alunos_doutorado.sql');
         $result = DB::fetch($query);
         $data['Doutorado'] = $result['computed'];
       
        $this->data = $data;
    }

    public function grafico()
    {
        $chart = new GenericChart;
        $chart->labels(array_keys($this->data));
        $chart->dataset('Quantidade', 'bar', array_values($this->data));

        return view('exAlunos', compact('chart'));
    }

    public function export($format)
    {
        if ($format == 'excel') {
            $export = new DadosExport([$this->data], array_keys($this->data));
            return $this->excel->download($export, 'ex_alunos_fflch.xlsx');
        }
    }

    public function listarExAlunos(Excel $excel, Request $request){
        $this->authorize('admins');
        $this->excel = $excel;

        $query = file_get_contents(__DIR__ . '/../../../Queries/listar_ex_alunos.sql');

        $curso = $request->curso ?? 1;
       
        //listar todos os cursos de gr
        if($curso == 1){
            $cursos = [];
            foreach(Util::cursos as $key => $curso){
                array_push($cursos, $key);
            }
            $curso = implode(',', $cursos);
        }

        $query = str_replace('__curso__',$curso, $query);

        $result = DB::fetchAll($query);
        $data = $result;

        $export = new DadosExport([$data], 
        [
            'Email', 
            'Nome aluno', 
            'Formação'
        ]);

        return $this->excel->download($export, 'Ex_Alunos.xlsx');

    }
}