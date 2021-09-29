<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Uspdev\Replicado\Posgraduacao;
use Carbon\Carbon;
use Uspdev\Utils\Generic;
use Uspdev\Replicado\Lattes;

class Defesa extends Model
{
    public static function listar($filters){

        # 1. Filter by year
        if(!array_key_exists('ano',$filters)) $filters['ano'] = Date('Y');
        $intervalo = [
            'inicio' => $filters['ano'] . '-01-01',
            'fim'    => $filters['ano'] . '-12-31'
        ];
        $defesas = Posgraduacao::listarDefesas($intervalo);

        # 2. Filter by codcur
        $defesas = collect($defesas);
        if(array_key_exists('codcur',$filters) && !empty($filters['codcur'])) {
            $defesas = $defesas->where('codcur',$filters['codcur'])->all();
        }

        # 3. Dados que serão de fato retornados
        $aux = [];
        foreach ($defesas as $defesa) {
            $data = Carbon::createFromFormat('Y-m-d H:i:s', $defesa['dtadfapgm'])->format('d/m/Y');
            $aux[] = [
                'discente_id' => Generic::crazyHash($defesa['codpes']),
                'defesa_id'   => md5($defesa['codpes'] + $defesa['codare'] + $defesa['codcur'] + str_replace('/','',$data)),
                'nome'        => $defesa['nompes'],
                'nivel'       => $defesa['nivpgm'],
                'codare'      => $defesa['codare'],
                'codcur'      => $defesa['codcur'],
                'nomcur'      => $defesa['nomcur'],
                'nomare'      => $defesa['nomare'],
                'titulo_html' => html_entity_decode($defesa['tittrb'], ENT_QUOTES, 'UTF-8'),
                'titulo'      => strip_tags(html_entity_decode($defesa['tittrb'], ENT_QUOTES, 'UTF-8')),
                'data'        => $data
            ];
        }
        $defesas = $aux;

        # Convertendo tudo para collection
        $defesas = collect($defesas)->map(function ($item) {
            return (object) $item;
        });

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
