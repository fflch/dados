<?php

namespace App\Utils;
use Uspdev\Replicado\DB;
use Uspdev\Replicado\Graduacao;
use App\Utils\Util;
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
                
                ORDER BY t3.nompes";

        return DB::fetchAll($query);
    }

    public static function listarAlunoEstrangeiro(int $year)
    {
        $query = "SELECT DISTINCT V.codpes, V.nompes, L.dtainivin from LOCALIZAPESSOA L
                    JOIN VINCULOPESSOAUSP V ON V.codpes = L.codpes
                    WHERE L.tipvin = 'ALUNOCONVENIOINT' 
                    AND L.sitatl = 'A' and L.codundclg = 8
                    AND L.dtainivin LIKE '%$year%'";

        return DB::fetchAll($query);
    }

    public static function listarAlunosIntercambistas($year, $curso)
    {
        $addquery = '';
        if ($curso == 1){//todos os cursos
            $cursos = implode(',', Graduacao::obterCodigosCursos());
            $addquery = "AND V.codcurgrd IN ({$cursos})";
        } else if ($curso != 1) {
            $addquery = "AND V.codcurgrd = $curso";
        }
        $query = "SELECT DISTINCT I.codpes, V.nompes, I.dtainiitb from INTERCAMBIOUSPORGAO I
                    JOIN VINCULOPESSOAUSP V ON I.codpes = V.codpes 
                    WHERE I.codclgrsp = 8 
                    and I.dtadsialu IS NULL --Data de desistência do aluno.
                    AND I.dtainiitb LIKE '%$year%'
                    $addquery";

        return DB::fetchAll($query);
    }

    public static function listarDocentesEstrangeiros(int $year, int $setor)
    {
        $addquery = '';
        if($setor == 1){//todos os setores
            $setores = [];
                foreach(Util::departamentos as $setor){
                    array_push($setores, $setor[0]);
                }
            $setor = implode(',', $setores);
            $addquery = "AND s.codset IN ({$setor})";
        } else if ($setor != 1) {
            $addquery = "AND s.codset = $setor";
        }
        $query = " SELECT DISTINCT i.codpes, l.nompes, i.dtainiatvitb from INTERCAMPROFVISITANTE i 
                    JOIN LOCALIZAPESSOA l ON i.codpes = l.codpes
                    JOIN SETOR s on i.codsetpesrsp = s.codset 
                    WHERE l.tipvin = 'PROFVISITINTERNAC'
                    AND i.dtainiatvitb LIKE '%$year%'
                    $addquery
                    ORDER BY l.nompes";

        return DB::fetchAll($query);
    }
}