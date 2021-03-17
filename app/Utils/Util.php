<?php

namespace App\Utils;
use Uspdev\Replicado\DB;

class Util
{

    const departamentos = [
        'FLA' => 'Antropologia',
        'FLP' => 'Ciência Política',
        'FLF' => 'Filosofia',
        'FLH' => 'História',
        'FLC' => 'Letras Clássicas e Vernáculas',
        'FLM' => 'Letras Modernas',
        'FLO' => 'Letras Orientais',
        'FLL' => 'Linguística',
        'FSL' => 'Sociologia',
        'FLT' => 'Teoria Literária e Literatura Comparada',
        'FLG' => 'Geografia'
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