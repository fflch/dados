<?php

namespace App\Http\Controllers\Dados;

use Uspdev\Replicado\DB;

class AlunosAtivosGradTipoIngressoDados
{
    public function listar()
    {
        $data = [];

        // Array com os tipos de ingresso cadastrados no banco dos alunos de graduação. 
        $ingresso = [
                    'Vestibular' => 'Vesitbular',
                    'Vestibular%Lista' => 'Vestibular Lista de espera',
                    '%SISU%' => 'SISU',
                    'Transf USP' => 'Transferência interna USP',
                    'Transf Externa' => 'Transferência externa',
                    'Conv%' => 'Convênio',
                    'Cortesia Diplom%' => 'Cortesia Diplomática',
                    'Liminar' => 'Liminar',
                    'REGULAR' => 'Regular',
                    'processo seletivo' => 'Processo seletivo',
                    'ESPECIAL' => 'ESPECIAL',
                    'Especial' => 'Especial',
                    'anterior a out/2002' => 'Anterior a out/2002',
        ];

        /* Contabiliza alunos da Graduação por tipo de ingresso */
        $query = file_get_contents(__DIR__ . '/../../../../Queries/conta_alunos_ativos_ingresso.sql');
        foreach ($ingresso as $key => $tipo) {
            $query_por_tipo = str_replace('__tipo__', $key, $query);
            $result = DB::fetch($query_por_tipo);
            $data[$tipo] = $result['computed'];
        }
        return $data;
    }
}