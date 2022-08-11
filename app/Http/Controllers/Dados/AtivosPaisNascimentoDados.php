<?php

namespace App\Http\Controllers\Dados;

use Uspdev\Replicado\DB;
use App\Exports\DadosExport;
use Illuminate\Http\Request;
use App\Http\Requests\AtivosPaisNascimentoRequest;

class AtivosPaisNascimentoDados
{
    public function listar(AtivosPaisNascimentoRequest $request){
        $data = [];
        $request->validated();

        $vinculoreplicado = [
            'ALUNOGR' => 'ALUNOGR', 
            'ALUNOPOS' => 'ALUNOPOS', 
            'ALUNOCEU' => 'ALUNOCEU', 
            'ALUNOPD' => 'ALUNOPD',
            'DOCENTE' => 'SERVIDOR'
        ];

        $nacionalidades = [
            0 => ['nome' => 'Nascidos no Brasil', 'where' => 'AND cp.codpasnas = 1'],
            1 => ['nome' => 'Estrangeiros', 'where' => 'AND cp.codpasnas <> 1 AND cp.codpasnas <> NULL'],
            2 => ['nome' => 'Sem informações', 'where' => 'AND cp.codpasnas = NULL']
        ];

        $vinculo = $request->vinculo ?? 'ALUNOGR';

        $vinculoquery = isset($vinculoreplicado[$vinculo]) ? $vinculoreplicado[$vinculo] : '"Vínculo não encontrado"';

        /* Contabiliza alunos e docentes nascidos e não nascidos no BR */
        $query = file_get_contents(__DIR__ . '/../../../../Queries/conta_ativos_nacionalidade.sql');
        foreach ($nacionalidades as $nacionalidade){
            $query_por_vinculo = str_replace('__vinculo__', $vinculoquery, $query);

            if($vinculoquery == 'SERVIDOR'){
                $query_por_vinculo = str_replace('__codpasnas__', $nacionalidade['where']." AND lp.tipvinext = 'Docente'", $query_por_vinculo);
            
            } else {
                $query_por_vinculo = str_replace('__codpasnas__', $nacionalidade['where'], $query_por_vinculo);
            }
            $result = DB::fetch($query_por_vinculo);

            $data[$nacionalidade['nome']] = $result['computed'];    
        }
    
        return ['dados' => $data, 'vinculo' => $vinculo];
    }
}