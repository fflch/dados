<?php

namespace App\Utils;
use Uspdev\Replicado\DB;

class ReplicadoTemp
{
    public static function credenciados($codare = null){
        date_default_timezone_set('America/Sao_Paulo');
        
        
        $query = "SELECT r.codpes, p.nompes, r.codare FROM R25CRECREDOC r 
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

    /**
     * Método para retornar os monitores ativos da fflch
     */
    public static function listarMonitores()
    {
        $query = "SELECT DISTINCT t1.codpes, 
                t3.nompes AS 'Nome',
                t4.codema AS 'E-mail',
                t1.dtainiccd AS 'Início da Bolsa',
                t1.dtafimccd AS 'Fim da Bolsa'
                
                FROM BENEFICIOALUCONCEDIDO t1
                INNER JOIN BENEFICIOALUNO t2
                ON t1.codbnfalu = t2.codbnfalu
                
                INNER JOIN PESSOA t3
                ON t1.codpes = t3.codpes
                
                INNER JOIN EMAILPESSOA t4
                ON t1.codpes = t4.codpes
                
                AND t1.dtafimccd > GETDATE()
                AND t1.dtacanccd IS NULL
                AND t2.codbnfalu = 32
                AND t4.stamtr = 'S'
                AND t1.codslamon = 22
                
                AND (t4.stausp = 'S' OR t4.codema LIKE '%usp.br%')

                ORDER BY t3.nompes";

        return DB::fetchAll($query);
    }
}