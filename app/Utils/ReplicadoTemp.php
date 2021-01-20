<?php

namespace App\Utils;
use Uspdev\Replicado\DB;

class ReplicadoTemp
{
    public static function credenciados($codare){
        date_default_timezone_set('America/Sao_Paulo');
        
        
        $query = "SELECT r.codpes, p.nompes FROM R25CRECREDOC r 
                  INNER JOIN PESSOA p ON r.codpes = p.codpes
                  WHERE r.codare = CONVERT(INT, :codare) 
                  AND r.dtavalfim > CONVERT(datetime, :datafim)
                  ";

        $param = [
            'codare' => $codare,
            'datafim' => date('Y-m-d')
        ];
        return DB::fetchAll($query, $param);
    }
}