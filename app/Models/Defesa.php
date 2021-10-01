<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Uspdev\Replicado\Posgraduacao;
use Carbon\Carbon;
use Uspdev\Utils\Generic;
use Uspdev\Replicado\Lattes;

class Defesa extends Model
{
    public static function listar($filters, $isAPI = false){

        # 1. Filter by year
        if(!array_key_exists('ano',$filters)) $filters['ano'] = Date('Y');
        $intervalo = [
            'inicio' => $filters['ano'] . '-01-01',
            'fim'    => $filters['ano'] . '-12-31'
        ];
       
        
        # 2. Filter by codcur
        if(array_key_exists('codcur',$filters) && !empty($filters['codcur'])) {
            if($isAPI){
                $defesas = Defesa::whereYear('data_defesa',$filters['ano'])->where('codcur',$filters['codcur'])->get()->toArray();
            }else{
                $defesas = Defesa::whereYear('data_defesa',$filters['ano'])->where('codcur',$filters['codcur'])->paginate(15);

            }
            $mestrado = Defesa::whereYear('data_defesa',$filters['ano'])->where('codcur',$filters['codcur'])->where('nivpgm','ME')->count();
            $doutorado =  Defesa::whereYear('data_defesa',$filters['ano'])->where('codcur',$filters['codcur'])->where('nivpgm','DO')->count();
            $doutorado_direto =  Defesa::whereYear('data_defesa',$filters['ano'])->where('codcur',$filters['codcur'])->where('nivpgm','DD')->count();
        }else{
            if($isAPI){
                $defesas = Defesa::whereYear('data_defesa',$filters['ano'])->get()->toArray();
            }else{
                $defesas = Defesa::whereYear('data_defesa',$filters['ano'])->paginate(15);
            }
            $mestrado = Defesa::whereYear('data_defesa',$filters['ano'])->where('nivpgm','ME')->count();
            $doutorado =  Defesa::whereYear('data_defesa',$filters['ano'])->where('nivpgm','DO')->count();
            $doutorado_direto =  Defesa::whereYear('data_defesa',$filters['ano'])->where('nivpgm','DD')->count();
        }
        if($isAPI){
            $aux = [];
            foreach ($defesas as $defesa) {
                $data = Carbon::createFromFormat('Y-m-d', $defesa['data_defesa'])->format('d/m/Y');
                $aux[] = [
                    'discente_id' => $defesa['discente_id'],
                    'defesa_id'   => $defesa['defesa_id'],
                    'nome'        => $defesa['nompes'],
                    'nivel'       => $defesa['nivpgm'],
                    'codare'      => $defesa['codare'],
                    'codcur'      => $defesa['codcur'],
                    'nomcur'      => $defesa['nomcur'],
                    'nomare'      => $defesa['nomare'],
                    'titulo_html' => html_entity_decode($defesa['titulo'], ENT_QUOTES, 'UTF-8'),
                    'titulo'      => strip_tags(html_entity_decode($defesa['titulo'], ENT_QUOTES, 'UTF-8')),
                    'data'        => $data
                ];
            }
            return $aux;
        }else{
           return   [
                        'mestrado' => $mestrado,
                        'doutorado' => $doutorado,
                        'doutorado_direto' => $doutorado_direto,
                        'defesas' => $defesas,
                    ];
        }

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
