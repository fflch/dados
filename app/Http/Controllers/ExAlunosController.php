<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Illuminate\Http\Request;
use Uspdev\Replicado\DB;
use App\Utils\Util;
use Khill\Lavacharts\Lavacharts;

class ExAlunosController extends Controller
{
    private $data;
    private $excel;
    private $vinculos;

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
        $data = [];    

        $this->vinculos = [
            'EXALUNOGR' => 'Ex-Alunos de Graduação',
            'EXALUNOPOS0' => 'Ex-Alunos de Pós-Graduação (Mestrado)', 
            'EXALUNOPOS1' => 'Ex-Alunos de Pós-Graduação (Doutorado)', 
        ];
  
        /* Contabiliza ex alunos de Graduação e Pós-Graduação (Mestrado e Doutorado). */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_ex_alunos.sql');
        foreach($this->vinculos as $key => $vinculo){
            if($key == 'EXALUNOGR'){
                $query_por_vinculo = str_replace('__codcur__', ' AND codcur IS NOT NULL', $query);
                $query_por_vinculo = str_replace('__grufor__',  "", $query_por_vinculo);
            }else if ($key == 'EXALUNOPOS0'){
                $query_por_vinculo = str_replace('__grufor__', ' AND grufor = 3', $query);
                $query_por_vinculo = str_replace('__codcur__',  "", $query_por_vinculo);
                
            } else{
                $query_por_vinculo = str_replace('__grufor__', ' AND grufor = 4', $query);
                $query_por_vinculo = str_replace('__codcur__',  "", $query_por_vinculo);
            }
            $result = DB::fetch($query_por_vinculo);
            $data[$vinculo] = $result['computed'];
        }
       
        $this->data = $data;
    }

    public function grafico()
    {
        $lava = new Lavacharts; 

        $reasons = $lava->DataTable();

        $reasons->addStringColumn('Reasons')
                ->addNumberColumn('Percent');

        foreach($this->data as $key=>$data) {
            $reasons->addRow([$key, (int)$data]);
        }
        
        $lava->PieChart('Ex Alunos', $reasons, [
            'title'  => 'Quantidade de Ex Alunos de Graduação e Pós-Graduação (Mestrado e Doutorado) da Faculdade de Filosofia, Letras e Ciências Humanas',
            'is3D'   => true,
            'height' => 700

        ]);

        return view('exAlunos', compact('lava'));
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
        $area = $request->area ?? 1;

        $nivel = $request->nivel ?? 1;

        if($nivel == 'gr'){
            //listar todos os cursos de gr
            if($curso == 1){
                $cursos = [];
                foreach(Util::cursos as $key => $curso){
                    array_push($cursos, $key);
                }
                $curso = implode(',', $cursos);
            }
            $aux = " AND T.codcur IN ($curso)";
            $query = str_replace('__nivel__',$aux, $query);
        } else if ($nivel == 1){
            $query = str_replace('__nivel__',"", $query);
        } else {
            if($area == 1){
                $areas = [];
                foreach(Util::getAreas() as $key => $area){
                    array_push($areas, $key);
                }
                $area = implode(',', $areas);
            }
            $aux = " AND T.codare IN ($area)";
            if($nivel != 'pgr'){
                if($nivel == 'do'){
                    $aux .= " AND V.nivpgm = 'DO'";
                } else {
                    $aux .= " AND V.nivpgm = 'ME'";
                }
            }
            $query = str_replace('__nivel__',$aux, $query);
        } 
    
        $result = DB::fetchAll($query);
        $data = $result;

        $export = new DadosExport([$data], 
        [
            'Email', 
            'Nusp', 
            'Nome aluno', 
            'Formação'
        ]);

        return $this->excel->download($export, 'Ex_Alunos_Graduacao.xlsx');

    }

}