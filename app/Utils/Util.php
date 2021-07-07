<?php

namespace App\Utils;
use Carbon\Carbon;
use Uspdev\Replicado\Posgraduacao;

class Util
{

    const departamentos = [
        'FLA' => [591, 'Antropologia'],
        'FLP' => [602, 'Ciência Política'],
        'FLF' => [594, 'Filosofia'],
        'FLH' => [598, 'História'],
        'FLC' => [592, 'Letras Clássicas e Vernáculas'],
        'FLM' => [600, 'Letras Modernas'],
        'FLO' => [601, 'Letras Orientais'],
        'FLL' => [599, 'Linguística'],
        'FSL' => [604, 'Sociologia'],
        'FLT' => [603, 'Teoria Literária e Literatura Comparada'],
        'FLG' => [596, 'Geografia']
    ];    


    const cursos = [
        8010 => 'Filosofia',
        8021 => 'Geografia',
        8030 => 'História',
        8040 => 'Ciências Sociais',
        8051 => 'Letras',
    ];

    const racas = [
        'Indígena' => 1,
        'Branca' => 2,
        'Negra' => 3,
        'Amarela' => 4,
        'Parda' => 5,
        'Não informado' => 6
    ];

    public static function retornarCursoGrdPorDepartamento($sigla_departamento){
        $aux_cursos = [
            8010 => ['Filosofia', 'FLF'],
            8021 => ['Geografia', 'FLG'],
            8030 => ['História', 'FLH'],
            8040 => ['Ciências Sociais', 'FLA', 'FLP', 'FSL'],
            8051 => ['Letras', 'FLC', 'FLM', 'FLO', 'FLT', 'FLL'],
        ];
        $curso = [];
        foreach($aux_cursos as $key=>$value){
            if(in_array($sigla_departamento, $value)){
                $curso['codcur'] = $key; 
                $curso['nome_curso'] = $value[0]; 
            }
        }
        return $curso;
    }

    public static function getDepartamentos() {
        return self::departamentos;
    }
    
    public static function getCursos() {
        return self::cursos;
    }

    public static function formatarData($formato_atual, $formato_desejado, $data){

         return Carbon::CreateFromFormat($formato_atual, $data)->format($formato_desejado);
    }

    public static function getAreas(){
        $areas = Posgraduacao::areasProgramas(8);
        $aux_areas = [];
        foreach($areas as $value){
            $aux_areas[$value[0]['codare']] = $value[0]['nomare'];
        }
        return $aux_areas;
        
    }

    

}