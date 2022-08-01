<?php

namespace App\Http\Controllers\Dados;

use Uspdev\Replicado\DB;
use Illuminate\Http\Request;
use App\Utils\Util;
use App\Http\Requests\AlunosAtivosAutodeclaradosRequest;

class AlunosAtivosAutodeclaradosDados
{

    public static function listar(AlunosAtivosAutodeclaradosRequest $request){

            $data = [];
            $request->validated();

            $vinculos = [
                'ALUNOGR' => 'Aluno de Graduação', 
                'ALUNOPOS' => 'Aluno de Pós-Graduação', 
                'ALUNOCEU' => 'Aluno de Cultura e Extensão', 
                'ALUNOPD' => 'Aluno de Pós-Doutorado'
            ];

            $vinculo = $request->vinculo ?? 'ALUNOGR';

            $cores = Util::racas;

            $nome_vinculo = isset($vinculos[$vinculo]) ? $vinculos[$vinculo] : '"Vínculo não encontrado"';

            $query = file_get_contents(__DIR__ . '/../../../../Queries/conta_alunos_autodeclarados.sql');
            foreach ($cores as $key => $cor) {
                $query_por_cor = str_replace('__cor__', $cor, $query);
                $query_por_cor = str_replace('__vinculo__', $vinculo, $query_por_cor);
                $result = DB::fetch($query_por_cor);
                $data[$key] = $result['computed'];
            }

            return ['dados' => $data, 'nome_vinculo' => $nome_vinculo, 'vinculo' => $vinculo];
        }

} 