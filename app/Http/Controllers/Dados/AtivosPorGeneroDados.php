<?php

namespace App\Http\Controllers\Dados;

use App\Exports\DadosExport;
use Uspdev\Replicado\DB;
use Illuminate\Http\Request;
use App\Utils\Util;
use Uspdev\Replicado\Uteis;

class AtivosPorGeneroDados
{

    public function listar(Array $validated){

        $data = [];
        $siglas = ['F', 'M'];

        $vinculo = $validated['vinculo'] ?? 'ALUNOGR';
        $codcur = $validated['curso'] ?? null;

        /* Contabiliza alunos graduação gênero */
        $query = file_get_contents(__DIR__ . '/../../../../Queries/conta_ativos_genero.sql');
        foreach($siglas as $sigla){
            if($vinculo == 'DOCENTE'){
                $query = file_get_contents(__DIR__ . '/../../../../Queries/conta_docentes_genero.sql');                
            }else if($vinculo == 'SERVIDOR'){
                $query = file_get_contents(__DIR__ . '/../../../../Queries/conta_funcionarios_genero.sql');                
            }else if($vinculo == 'CHEFESADM'){
                $query = file_get_contents(__DIR__ . '/../../../../Queries/conta_chefes_administrativos_genero.sql');                
            }else if($vinculo == 'CHEFESDPTO'){
                $query = file_get_contents(__DIR__ . '/../../../../Queries/conta_chefes_departamento_genero.sql');                
            }else if($vinculo == 'COORD'){
                $query = file_get_contents(__DIR__ . '/../../../../Queries/conta_coordcursosgrad_genero.sql');                
            }
            $query_genero = str_replace('__genero__', $sigla, $query);
            $query_genero = str_replace('__tipvin__', $vinculo, $query_genero);


            if($vinculo == 'ALUNOGR' && isset($codcur)){
                $query_genero = str_replace('__join_alunogr__', 'JOIN SITALUNOATIVOGR s ON s.codpes = l.codpes', $query_genero);
                $query_genero = str_replace('__curso__', 'AND s.codcur = ' . $codcur, $query_genero);
            }else{
                $query_genero = str_replace('__join_alunogr__', '', $query_genero);
                $query_genero = str_replace('__curso__', '', $query_genero);

            }

            $result = DB::fetch($query_genero);

            $data[$sigla] = $result['computed'];

        }

        return ['dados' => $data, 'vinculo' => $vinculo, 'codcur' => $codcur];
    }
}