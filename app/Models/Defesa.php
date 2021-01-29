<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Uspdev\Replicado\Posgraduacao;
use Carbon\Carbon;

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

        # 3. Convertendo defesas dentro de $defesas para collection
        $defesas = collect($defesas)->map(function ($item) {
            return (object) $item;
        });

        # 4. Últimos tratamentos antes de devolver
        $defesas->each(function(&$defesa) {
            $defesa->dtadfapgm = Carbon::createFromFormat('Y-m-d H:i:s', $defesa->dtadfapgm)->format('d/m/Y');
        });  
        
        return $defesas;
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
