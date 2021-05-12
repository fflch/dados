<?php

namespace App\Http\Controllers;

use App\Charts\GenericChart;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Uspdev\Replicado\DB;
use Illuminate\Http\Request;
use App\Utils\Util;
use Uspdev\Replicado\Uteis;

class AtivosPorGeneroCursoGradController extends Controller
{
    private $data;
    private $excel;
    private $cod_curso;
    private $nome_curso;

    public function __construct(Excel $excel,Request $request){
        $this->excel = $excel;
        
        $data = [];
        $siglas = ['F', 'M'];

        $this->cod_curso = $request->route()->parameter('cod_curso') ?? 8051;
        
        $cursos = Util::cursos;
        $this->nome_curso = isset($cursos[$this->cod_curso]) ? $cursos[$this->cod_curso] : 'Curso não encontrado';
        


        /* Contabiliza alunos graduação gênero */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunogr_curso_genero.sql');
        foreach($siglas as $sigla){
            $query_genero_curso = str_replace('__sigla__', $sigla, $query);
            
            $query_genero_curso = str_replace('__curso__', $this->cod_curso, $query_genero_curso);
           
            $result = DB::fetch($query_genero_curso);
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
        $nome_curso = $this->nome_curso;
        $cod_curso = $this->cod_curso;
        $cursos = Util::cursos;

        $chart->dataset($nome_curso .' por Gênero', 'bar', array_values($this->data));

        return view('ativosGradGeneroCurso', compact('chart', 'nome_curso', 'cod_curso', 'cursos'));
    }

    public function export($format, Request $request)
    {
        $cod_curso = $request->route()->parameter('cod_curso') ?? 8051;
        $cursos = Util::cursos;
        $nome_curso = isset($cursos[$cod_curso]) ? $cursos[$cod_curso] : 'Curso não encontrado';

        $nome_curso = str_replace(' ','_', Uteis::removeAcentos(strtolower($nome_curso)));
        
        if($format == 'excel') {
            $export = new DadosExport([$this->data],['Feminino', 'Masculino']);
            return $this->excel->download($export, 'ativos_grad_genero_'.$nome_curso.'.xlsx'); 
        }
    }
}
