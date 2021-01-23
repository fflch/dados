<?php

namespace App\Utils;
use Uspdev\Replicado\DB;

class ReplicadoTemp
{
    public static function credenciados($codare = null){
        date_default_timezone_set('America/Sao_Paulo');
        
        
        $query = "SELECT r.codpes, p.nompes FROM R25CRECREDOC r 
                  INNER JOIN PESSOA p ON r.codpes = p.codpes
                  WHERE r.dtavalfim > CONVERT(datetime, :datafim)
                  ";
        $param = [
            'datafim' => date('Y-m-d')
        ];
        if($codare != null){
            $query .= " AND r.codare = CONVERT(INT, :codare)";
            $param['codare'] = $codare; 
        }
        
        return DB::fetchAll($query, $param);
    }
}