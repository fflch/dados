<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Uspdev\Replicado\Pessoa as ReplicadoPessoa;



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
}
