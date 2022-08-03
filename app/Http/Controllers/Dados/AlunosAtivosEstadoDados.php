<?php

namespace App\Http\Controllers\Dados;


use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Khill\Lavacharts\Lavacharts;
use Uspdev\Replicado\DB;

class AlunosAtivosEstadoDados
{
    public function listar(){
        
        $data = [];

        $query = file_get_contents(__DIR__ . '/../../../../Queries/conta_alunos_por_estado.sql');

        $result = DB::fetchAll($query);

        /* Contabiliza alunos da Graduação, Pós Graduação, Pós Doutorado e Cultura e Extensão
        nascidos no estado escolhido */

        foreach($result as $e){
            $data[$e['sglest']] = $e['computed'];
        }
        
        return $data;
    }
}