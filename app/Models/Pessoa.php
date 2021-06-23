<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Uspdev\Replicado\Pessoa as ReplicadoPessoa;
use Uspdev\Replicado\Lattes;
use Uspdev\Utils\Generic;



class Pessoa extends Model
{
    public static function vinculos(){
        return [
            'docentes'      => 'Docentes',
            'estagiarios'   => 'Estagiários(as)',
            'funcionarios'  => 'Funcionários(as)',
        ];
    }

    public static function listarDocentes(){
        // Falta fazer o filtro das columas - idem no defesas -  não expor todas colunas
        $docentes = Pessoa::where('tipo_vinculo', 'Docente')->whereIn('codset', [591,602,594,598,592,600,601,599,604,603,596,558])->get()->toArray();
        $retorno = [];
        foreach($docentes as $docente){
            $aux = [
                'docente_id' => Generic::crazyHash($docente['codpes']),
                'nompes'        => $docente['nompes'],
                'dtanas'       => $docente['dtanas'],
                'dtaflc'      => $docente['dtaflc'],
                'sexpes'      => $docente['sexpes'],
                'codset'      => $docente['codset'],
                'nomset'      => $docente['nomset'],
                'email'      => $docente['email'],
                'sitatl'      => $docente['sitatl'],
                'id_lattes'      => $docente['id_lattes']
            ];
            
            array_push($retorno, $aux);
        }
    

        return $retorno;
    }
}
