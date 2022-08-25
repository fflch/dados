<?php

namespace App\Http\Controllers\Dados;

use Uspdev\Replicado\DB;

class AlunosAtivosGradTipoIngressoDados
{
    public function listar()
    {
        $data = [];

        // Array com os tipos de ingresso cadastrados no banco dos alunos de graduação.
        $tiposIngresso = [
                    'Vestibular' => 'Vestibular – Primeira Lista',
                    'Vestibular%a' => 'Vestibular – Lista Extra',
                    '%SISU' => 'SISU – Primeira Lista',
                    '%SISU LE%' => 'SISU – Lista Extra',
                    'Transf USP' => 'Transferência interna',
                    'Transf Externa' => 'Transferência externa',
                    'Conv%' => 'Convênio',
                    'Liminar' => 'Liminar',
                    'Cortesia Diplom%' => 'Cortesia Diplomática',
        ];


        foreach ($tiposIngresso as $key => $value){
            if(isset($select) == False){
                $select = "SUM(COUNT(CASE WHEN v.tiping LIKE '".$key."' THEN 1 ELSE null END)) AS '".$value."'";
            } else {
                $select .= ", SUM(COUNT(CASE WHEN v.tiping LIKE '".$key."' THEN 1 ELSE null END)) AS '".$value."'";
            }
        }

        /* Contabiliza alunos da Graduação por tipo de ingresso */
        $query = file_get_contents(__DIR__ . '/../../../../Queries/conta_alunos_ativos_ingresso.sql');

        $query = str_replace('__select__', $select, $query);


        $data = DB::fetchAll($query)[0];

        return $data;
    }
}