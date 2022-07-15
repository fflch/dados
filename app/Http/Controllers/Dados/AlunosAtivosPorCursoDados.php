<?php

namespace App\Http\Controllers\Dados;

use Uspdev\Replicado\DB;
use Illuminate\Http\Request;
use App\Http\Requests\AlunosAtivosPorCursoRequest;

class AlunosAtivosPorCursoDados
{

    public static function listar(AlunosAtivosPorCursoRequest $request){
        $data = [];
        $request->validated();
        $tipvin = $request->tipvin ?? 'Não encontrado';
       
        $cursos = [
            8040 => ['nome' => 'Ciências Sociais', 'codsetprj' => [591, 602, 604]],
            8010 => ['nome' => 'Filosofia', 'codsetprj' => [594]],
            8021 => ['nome' => 'Geografia', 'codsetprj' => [596]],
            8030 => ['nome' => 'História', 'codsetprj' => [598]],
            8051 => ['nome' => 'Letras', 'codsetprj' => [592, 599, 600, 601, 603]],
        ];

        if($tipvin == 'ALUNOGR'){
            $query = file_get_contents(__DIR__ . '/../../../../Queries/conta_alunogr_curso.sql');
            foreach ($cursos as $key=>$value){
                $query_por_curso = str_replace('__curso__', $key, $query);
                $result = DB::fetch($query_por_curso);
                $data[$value['nome']] = $result['computed'];
            } 
           
        }else if($tipvin == 'ALUNOPD'){
            $query = file_get_contents(__DIR__ . '/../../../../Queries/conta_alunoposdoutorado_curso.sql');
            foreach( $cursos as $key=>$value){
                $query_curso = str_replace('__codsetprj__', implode (", ", $value['codsetprj']) , $query);
                $result = DB::fetch($query_curso);
                $data[$value['nome']] = $result['computed'];
            }
        }


        return $data;
    }

}
