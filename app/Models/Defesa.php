<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Uspdev\Replicado\Posgraduacao;

class Defesa extends Model
{
    public static function listar($filters){

        # 1. Filter by year
        if(!array_key_exists('ano',$filters)) $filters['ano'] = Date('Y');
        $intervalo = [
            'inicio' => $filters['ano'] . '-01-01',
            'fim'    => $filters['ano'] . '-12-31'
        ];
        $defesas = collect(Posgraduacao::listarDefesas($intervalo));

        # 2. Filter by codcur
        if(array_key_exists('codcur',$filters) && !empty($filters['codcur'])) {
            $defesas = $defesas->where('codcur',$filters['codcur'])->all();
        }

        return collect($defesas);
    }

    public static function anos(){
        return array_reverse(range(1950, Date('Y')));
    }

    public static function programas(){
        # Não muito eficiente, mas neste momento só quero eliminar os repetidos
        $programas = [];
        foreach(Posgraduacao::programas() as $programa){
            $programas[$programa['codcur']] = $programa['nomcur'];
        } 
        return $programas;
    }
}
