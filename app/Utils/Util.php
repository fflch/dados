<?php

namespace App\Utils;
use Uspdev\Replicado\DB;
use Carbon\Carbon;

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

    const areas = [
        8134 => 'Antropologia Social',
        8133 => 'Filosofia',
        8131 => 'Ciência Política',
        8135 => 'Geografia Física',
        8136 => 'Geografia Humana',
        8137 => 'História Econômica',
        8138 => 'História Social',
        8132 => 'Sociologia',
        8156 => 'Estudos Comparados de Literaturas de Língua Portuguesa',
        8142 => 'Filologia e Língua Portuguesa',
        8143 => 'Letras Clássicas',
        8144 => 'Língua e Literatura Alemã',
        8165 => 'Estudos da Tradução',
        8163 => 'Estudos Linguísticos',
        8146 => 'Estudos Lingüísticos, Literários e Tradutológicos em Francês',
        8164 => 'Estudos Literários e Culturais',
        8139 => 'Lingüística: Semiótica e Lingüística Geral',
        8145 => 'Língua Espanhola e Literaturas Espanhola e Hispano-Americana',
        8147 => 'Estudos Lingüísticos e Literários em Inglês',
        8148 => 'Língua, Literatura e Cultura Italianas',
        8149 => 'Literatura Brasileira',
        8150 => 'Literatura Portuguesa',
        8151 => 'Teoria Literária e Literatura Comparada',
        8152 => 'Língua Hebraica, Literatura e Cultura Judaica',
        8154 => 'Língua, Literatura e Cultura Árabe',
        8155 => 'Literatura e Cultura Russa',
        8157 => 'Língua, Literatura e Cultura Japonesa',
        8158 => 'Estudos Judaicos',
        8159 => 'Estudos Árabes',
        8160 => 'Estudos da Tradução',
        8161 => 'Humanidades, Direitos e Outras Legitimidades',
        8162 => 'Mestrado Profissional em Letras em Rede Nacional'
    ];

    const racas = [
        'Indígena' => 1,
        'Branca' => 2,
        'Negra' => 3,
        'Amarela' => 4,
        'Parda' => 5,
        'Não informado' => 6
    ];

    public static function getDepartamentos() {
        return self::departamentos;
    }
    
    public static function getCursos() {
        return self::cursos;
    }

    public static function formatarData($formato_atual, $formato_desejado, $data){

         return Carbon::CreateFromFormat($formato_atual, $data)->format($formato_desejado);
    }

    

}