<?php

namespace App\Utils;
use Uspdev\Replicado\DB;

class ReplicadoTemp
{
    public static function credenciados($codare){
        # 2020-12-31 deve ser uma data fixa 
        $query = "SELECT r.codpes, p.nompes FROM R25CRECREDOC r 
                  INNER JOIN PESSOA p ON r.codpes = p.codpes
                  WHERE r.codare = CONVERT(INT, :codare) 
                  AND r.dtavalfim > '2020-12-31'
                  ";

        $param = [
            'codare' => $codare
        ];
        return DB::fetchAll($query, $param);
    }
}