<?php

namespace App\Http\Controllers\Dados;

use App\Exports\DadosExport;
use Uspdev\Replicado\DB;
use Illuminate\Http\Request;
use App\Utils\Util;
use Uspdev\Replicado\Uteis;

class AtivosPorGeneroDados
{

    public function listar(Array $validated){

        $data = [];

        $vinculo = $validated['vinculo'] ?? 'ALUNOGR';
        $codcur = $validated['curso'] ?? null;

        $query = file_get_contents(__DIR__ . '/../../../../Queries/conta_ativos_genero.sql');

        $params = ["ALUNOGR"    =>  ["join" => "JOIN SITALUNOATIVOGR s ON s.codpes = l.codpes",
                                    "condicao" =>  "AND l.tipvin = 'ALUNOGR'".(isset($codcur) ? "AND s.codcur = ".$codcur : "")],

                   "ALUNOPOS"   =>  ["join" => null,
                                    "condicao" => "AND l.tipvin = 'ALUNOPOS'"],

                   "ALUNOCEU"   =>  ["join" => null,
                                    "condicao" => "AND l.tipvin = 'ALUNOCEU'"],

                   "ALUNOPD"    =>  ["join" => null,
                                    "condicao" => "AND l.tipvin = 'ALUNOPD'"],

                   "DOCENTE"    =>  ["join" =>  null,
                                    "condicao" =>  "AND l.tipvinext LIKE 'Docente'"],

                   "SERVIDOR"   =>  ["join" =>  null,
                                    "condicao" =>  "AND l.tipvinext = 'Servidor'"],

                   "CHEFESADM"  =>  ["join" =>  null,
                                    "condicao" =>  "AND l.codpes IN (SELECT codpes FROM LOCALIZAPESSOA loc
                                                    WHERE loc.tipvinext = 'Servidor' AND loc.sitatl = 'A') 
                                                    AND l.tipvinext = 'Servidor Designado'"],

                   "CHEFESDPTO" =>  ["join" =>  null,
                                    "condicao" =>  "AND l.nomfnc = 'Ch Depart Ensino'"],

                   "COORD"      =>  ["join" =>  null,
                                    "condicao" =>  "AND nomfnc LIKE '%Coord Cursos Grad%'"],

                   "ESTAGIARIORH"   =>  ["join" =>  null,
                                        "condicao" => "AND l.tipvin = 'ESTAGIARIORH'"]

        ];


        $subs = ['__join__', '__condicao__'];

        $querygenero = str_replace($subs, $params[$vinculo], $query);

        $result = DB::fetchAll($querygenero);

        foreach($result as $s){
            $data[$s['sexpes']] = $s['computed'];
        }

        return ['dados' => $data, 'vinculo' => $vinculo, 'codcur' => $codcur];
    }
}