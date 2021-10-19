<?php

namespace App\Http\Controllers;

use Uspdev\Replicado\DB;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Khill\Lavacharts\Lavacharts;
use Illuminate\Http\Request;

class IngressantesGradGeneroCursoController extends Controller
{
    private $data;
    private $excel;
    public function __construct(Excel $excel,  Request $request){
        $this->excel = $excel;
        $data = [];
        
        $anos = [];
        $ano_ini = $request->ano_ini ?? date("Y") - 5;
        $ano_fim = $request->ano_fim ?? date("Y");

        if($ano_ini > $ano_fim){ 
            $aux = $ano_fim;
            $ano_fim = $ano_ini;
            $ano_ini = $aux;
        }
        
        for ($i = $ano_ini; $i <= $ano_fim ; $i++) { 
            array_push($anos,(int) $i);
        }

        $curso = $request->curso ?? 'Letras';
        $cursos = [
            'Sociais' => ['nome' => 'Ciências Sociais', 'cod' => '8040'],
            'Filosofia' => ['nome' => 'Filosofia', 'cod' => '8010'],
            'Geografia' => ['nome' => 'Geografia', 'cod' => '8021'],
            'Historia' => ['nome' => 'História', 'cod' => '8030'],
            'Letras' => ['nome' => 'Letras', 'cod' => '8050, 8051, 8060']
        ];


        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_ingressantes_graduacao_curso_genero.sql');
        /* Contabiliza aluno graduação Geografia - por ano - por gênero*/
        foreach ($anos as $ano){
            $query = str_replace('__codcur__', $cursos[$curso]['cod'], $query);
            $_query = str_replace('__ano__', $ano, $query);
            
            $query_por_ano_masc = str_replace('__genero__', 'M', $_query);
            
            $result_mas = DB::fetch($query_por_ano_masc);
            
            $query_por_ano_fem = str_replace('__genero__', 'F', $_query);
            $result_fem = DB::fetch($query_por_ano_fem);

            $data[$ano]['Masculino'] = $result_mas['computed'];
            $data[$ano]['Feminino'] = $result_fem['computed'];
        } 

        $this->data = $data;
    }

    public function grafico(Request $request){
        $anos = [];
        
        for($year = (int)date("Y"); $year >= 2000; $year--){
            array_push($anos, $year);
        }

        $cursos = [
            'Sociais' => ['nome' => 'Ciências Sociais', 'cod' => '8040'],
            'Filosofia' => ['nome' => 'Filosofia', 'cod' => '8010'],
            'Geografia' => ['nome' => 'Geografia', 'cod' => '8021'],
            'Historia' => ['nome' => 'História', 'cod' => '8030'],
            'Letras' => ['nome' => 'Letras', 'cod' => '8050, 8051, 8060']
        ];

        $curso = $request->curso ?? 'Letras';
        $nome_curso = $cursos[$curso]['nome'];

        $lava = new Lavacharts; // See note below for Laravel
        $genero  = $lava->DataTable();

        $genero->addStringColumn('Ano')
            ->addNumberColumn('Masculino')
            ->addNumberColumn('Feminino');
          
        
        foreach($this->data as $key=>$data) {
            $genero->addRow([$key, $data['Masculino'], $data['Feminino']]);
        }


        $lava->LineChart('Genero', $genero, [
            'legend' => [
                'position' => 'top',
                'alignment' => 'center',
                
            ],
            'height' => 500,
            'interpolateNulls' => true,
            'vAxis' => ['format' => 0],
            'colors' => ['#273e74', 'green'],
            'animation' => [
                'startup' => true,
                'easing' => 'inAndOut'
            ],

        ]);

        

        return view('ingressantesGraduacaoGeneroCurso', compact('lava', 'anos', 'cursos', 'nome_curso'));
    }

    public function export($format, Request $request){
        $data = [];
        $masculino = [];
        foreach($this->data as $_data){
            array_push($masculino, $_data['Masculino']);
        }
        array_unshift($masculino, 'Masculino');
        $feminino = [];
        foreach($this->data as $_data){
            array_push($feminino, $_data['Feminino']);
        }
        array_unshift($feminino, 'Feminino');
        array_push($data, $masculino, $feminino);


        $curso = $request->curso ?? 'Letras';
        $labels = array_keys($this->data);
        array_unshift($labels, 'Ano');

        if($format == 'excel') {
            $export = new DadosExport($data,$labels);
            return $this->excel->download($export, 'ingressantes_'.$curso .'_por_genero_e_ano.xlsx');
        }
    }
}
