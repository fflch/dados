<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Uspdev\Replicado\Pessoa as ReplicadoPessoa;
use Uspdev\Replicado\Lattes;



class Pessoa extends Model
{
    public static function vinculos(){
        return [
            'docentes'      => 'Docentes',
            'estagiarios'   => 'Estagiários(as)',
            'funcionarios'  => 'Funcionários(as)',
        ];
    }

    public static function listar(){
        // Falta fazer o filtro das columas - idem no defesas -  não expor todas colunas
        //$pessoas = collect(ReplicadoPessoa::listarDocentes());

        return collect([]);
    }

    public static function listarDocentes(){
        $retorno = ReplicadoPessoa::listarTodosDocentes();
        $docentes = [];
        foreach($retorno as $docente){
            $aux = [];
            $aux['nusp'] = $docente['codpes'];
            $aux['id_lattes'] = $docente['id_lattes'];
            $aux['situacao'] = $docente['sitatl'];
            $aux['nome'] = $docente['nompes'];
            $aux['codsetor'] = $docente['codset'];
            $aux['departamento'] = $docente['nomset'];
            $aux['email'] = $docente['codema'];
            $aux['data_nascimento'] = $docente['dtanas'];
            $aux['data_falecimento'] = $docente['dtaflc'];
            array_push($docentes, $aux);
        }
        return $docentes;
    }
}
