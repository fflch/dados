<?php

namespace App\Utils;
use Uspdev\Replicado\DB;

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

    public static function getDepartamentos() {
        return self::departamentos;
    }
    
    public static function getCursos() {
        return self::cursos;
    }
}