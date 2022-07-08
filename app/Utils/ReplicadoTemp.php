<?php

namespace App\Utils;
use Uspdev\Replicado\DB;
use Uspdev\Replicado\Graduacao;
use Uspdev\Replicado\Pessoa;
use Uspdev\Replicado\Posgraduacao;
use App\Utils\Util;

class ReplicadoTemp
{
    public static function credenciados($codare = null){
        date_default_timezone_set('America/Sao_Paulo');

        $query = "SELECT DISTINCT r.codpes, l.nompes
        FROM R25CRECREDOC r
        INNER JOIN LOCALIZAPESSOA l ON l.codpes = r.codpes
        WHERE r.dtavalfim > CONVERT(datetime, :datafim)
        AND l.sitatl IN ('A', 'P')
        AND (l.tipvinext IN ('Docente','Docente Aposentado') OR l.tipvin IN ('EXTERNO'))";

        $param = [
            'datafim' => date('Y-m-d')
        ];
        if($codare != null){
            $query .= " AND r.codare = CONVERT(INT, :codare)";
            $param['codare'] = $codare;
        }else{
            $codare = implode(',',array_column(Posgraduacao::programas(8), 'codare'));
            $query .= " AND r.codare in ($codare)";
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
        } else {
            $addquery = "AND V.codcurgrd IN ($curso)";
        }
        $query = "SELECT DISTINCT I.codpes, V.nompes, I.dtainiitb, C.nomcur from INTERCAMBIOUSPORGAO I
                    JOIN VINCULOPESSOAUSP V ON I.codpes = V.codpes
                    JOIN CURSOGR C ON V.codcurgrd = C.codcur
                    WHERE I.codclgrsp = 8
                    and I.dtadsialu IS NULL --Data de desistência do aluno.
                    AND I.dtainiitb LIKE '%$year%'
                    $addquery";

        return DB::fetchAll($query);
    }

    public static function listarDocentesEstrangeiros(int $year, $setor)
    {
        $addquery = '';
        if($setor == 1){//todos os setores
            $setores = [];
                foreach(Util::departamentos as $key => $setor){
                    array_push($setores, $key);
                }
            $setor = "'".implode("','", $setores)."'";
            $addquery = "AND s.nomabvset IN ({$setor})";
        } else {
            $addquery = "AND s.nomabvset IN ($setor)";
        }
        $query = " SELECT DISTINCT i.codpes, l.nompes, i.dtainiatvitb, s.nomabvset from INTERCAMPROFVISITANTE i
                    JOIN LOCALIZAPESSOA l ON i.codpes = l.codpes
                    JOIN SETOR s on i.codsetpesrsp = s.codset
                    WHERE l.tipvin = 'PROFVISITINTERNAC'
                    AND i.dtainiatvitb LIKE '%$year%'
                    $addquery
                    ORDER BY l.nompes";

        return DB::fetchAll($query);
    }


    /**
     * Método para retornar os chefes administrativos da fflch
     */
    public static function listarChefesAdministrativos()
    {
        $query = "SELECT L.codpes,
                L.nompes,
                L.nomset,
                L.codema
                from LOCALIZAPESSOA  L
                WHERE L.tipvinext = 'Servidor Designado'
                AND L.codpes
                IN (Select codpes
                    from LOCALIZAPESSOA  L
                    where L.tipvinext = 'Servidor'
                    and L.codundclg = 8
                    and L.sitatl = 'A')
                ORDER BY L.nompes";

        return DB::fetchAll($query);
    }

    /**
     * Método para retornar os chefes de departamento da fflch
    */
    public static function listarChefesDepartamento()
    {
        $query = "SELECT L.codpes,
                L.nompes,
                L.nomset,
                E.codema
                from LOCALIZAPESSOA  L
                JOIN EMAILPESSOA E ON L.codpes = E.codpes
                WHERE L.nomfnc = 'Ch Depart Ensino'
                AND L.codundclg = 8
                AND L.sitatl = 'A'
                AND E.codema LIKE '%@usp.br%'
                ORDER BY L.nompes";

        return DB::fetchAll($query);
    }

    public static function listarEvasao($year, $curso)
    {
        $addquery = '';
        if ($curso == 1){//todos os cursos Graduação
            $cursos = implode(',', Graduacao::obterCodigosCursos());
            $addquery = "AND h.codcur IN ({$cursos})";
        } else {
            $addquery = "AND h.codcur = $curso";
        }
        $query = "SELECT DISTINCT p.codpes,
                    p.tiping,
                    p.tipencpgm,
                    p.dtaing,
                    p.dtaini,
                    c.nomcur
                from PROGRAMAGR p
                JOIN HABILPROGGR AS h ON p.codpes = h.codpes
                JOIN CURSOGR AS c ON h.codcur = c.codcur
                WHERE (p.tipencpgm LIKE '%Abandono%'
                    OR p.tipencpgm LIKE '%Cancelamento%'
                    OR p.tipencpgm = 'Encerramento novo ingresso'
                    OR p.tipencpgm LIKE '%Ingressante sem Frequ%'
                    OR p.tipencpgm LIKE '%normas de retorno ao Curso%'
                    OR p.tipencpgm LIKE '%Evas%')
                AND p.dtaini LIKE '%$year%'
                AND c.codclg = 8
                $addquery";

        return DB::fetchAll($query);
    }

    public static function listarTransferencia($year, $curso, $tipo)
    {
        $addquery = '';
        if ($curso == 1){//todos os cursos
            $cursos = implode(',', Graduacao::obterCodigosCursos());
            $addquery = "AND c.codcur IN ({$cursos})";
        } else {
            $addquery = "AND c.codcur = $curso";
        }
        $query = "SELECT DISTINCT p.codpes,
                    p.tiping,
                    p.dtaing,
                    c.nomcur
                FROM PROGRAMAGR p
                JOIN HABILPROGGR AS h ON p.codpes = h.codpes
                JOIN CURSOGR AS c ON h.codcur = c.codcur
                WHERE p.tiping = '$tipo'
                AND p.dtaing LIKE '%$year%'
                $addquery
                AND c.codclg = 8";

        return DB::fetchAll($query);
    }

    public static function listarBolsas($year, $curso)
    {
        $addquery = '';
        if ($curso == 1){//todos os cursos
            $cursos = implode(',', Graduacao::obterCodigosCursos());
            $addquery = "AND v.codcurgrd IN ({$cursos})";
        } else {
            $addquery = "AND v.codcurgrd = $curso";
        }

        $query = "SELECT DISTINCT b.codbnfalu, b.nombnfloc
        FROM BENEFICIOALUNO b
        INNER JOIN BENEFICIOALUCONCEDIDO a ON a.codbnfalu = b.codbnfalu
        INNER JOIN VINCULOPESSOAUSP v on v.codpes = a.codpes
        AND a.anoofebnf in ($year, $year"."1, ".$year."2)
        AND v.tipvin IN ('ALUNOGR')
        AND v.codclg = 8
        AND b.dtadtv IS NULL
        $addquery";

        return DB::fetchAll($query);
    }

    public static function contarBeneficiantesPorBolsa($year, $curso, $tipo)
    {
        $addquery = '';
        if ($curso == 1){//todos os cursos
            $cursos = implode(',', Graduacao::obterCodigosCursos());
            $addquery = "AND v.codcurgrd IN ({$cursos})";
        } else {
            $addquery = "AND v.codcurgrd = $curso";
        }
        $query = "SELECT count ( b.codpes)
                 FROM VINCULOPESSOAUSP v
                    JOIN BENEFICIOALUCONCEDIDO b
                    ON b.codpes = v.codpes
                 where v.tipvin IN ('ALUNOGR')
                    AND b.codbnfalu = $tipo
                    AND b.anoofebnf in ($year, $year"."1, ".$year."2)
                    $addquery
                    AND v.codclg = 8";

        return DB::fetch($query);
    }

    public static function listarAlunosAtivosPrograma($codare)
    {
        $query = "SELECT DISTINCT v.nompes, v.codpes, v.codare, v.nivpgm, v.dtainivin, v.sitatl, p.sexpes , v.tipvin FROM VINCULOPESSOAUSP v
                    JOIN PESSOA p  ON (p.codpes = v.codpes)
                    WHERE v.tipvin IN ('ALUNOPOS', 'ALUNOPD')
                    AND v.codare = convert(int,:codare)
                    AND v.codclg = convert(int,:codundclg)
                    AND v.sitatl = 'A'
                    ORDER BY v.nompes ASC";
        $param = [
            'codare' => $codare,
            'codundclg' => getenv('REPLICADO_CODUNDCLG'),
        ];

        return DB::fetchAll($query, $param);
    }


    public static function obterVinculo($codpes)
    {
        $query = "SELECT tipfnc FROM VINCULOPESSOAUSP WHERE codpes = ".$codpes." and sitatl <> 'D' and tipfnc is not null";
        if(DB::fetchAll($query) != []){
            $vinculos = DB::fetchAll($query)[0]['tipfnc'];
        }else{
            $query = "SELECT tipvin FROM VINCULOPESSOAUSP WHERE codpes = ".$codpes." and sitatl <> 'D' and dtafimvin  is null";
            $vinculo = DB::fetchAll($query);
            if($vinculo != []){
                $vinculos = '';
                foreach($vinculo as $value){
                    $aux = $value['tipvin'];
                    if($aux == 'ALUNOGR' || $aux == 'ALUNOPD' || $aux == 'ALUNOPOS' || $aux == 'ALUNOESP' ||
                    $aux == 'ALUNOCEU'){
                        $aux = 'Discente';
                    }

                    $vinculos .= ucfirst(strtolower($aux));
                    if($value['tipvin'] != $vinculo[sizeof($vinculo) - 1]['tipvin']){
                        $vinculos .= ', ';
                    }
                }
            }else{
                return '-';
            }

        }
        return $vinculos;
    }

    public static function obterQuestionarioSocioeconomicoFuvest($ano, $curso){
        $fuvest_qtnsocioecono = [];

        $codclg = getenv('REPLICADO_CODUNDCLG');
        $query_ingressantes = "SELECT v.codpes, v.nompes,
        (CASE WHEN p.sexpes = 'M' THEN 'Masculino.' ELSE (CASE WHEN p.sexpes = 'F' THEN 'Feminino.' ELSE '' END) END) AS sexpes,
        (CASE WHEN c.codraccor = 1 THEN 'Indígena.' ELSE
            (CASE WHEN c.codraccor = 2 THEN 'Branca.' ELSE
                (CASE WHEN c.codraccor = 3 THEN 'Negra.' ELSE
                    (CASE WHEN c.codraccor = 4 THEN 'Amarela.' ELSE
                        (CASE WHEN c.codraccor = 5 THEN 'Parda.' ELSE '' END)
                    END)
                END)
            END)
        END) AS codraccor
        FROM VINCULOPESSOAUSP v
        INNER JOIN PESSOA p ON p.codpes = v.codpes
        INNER JOIN COMPLPESSOA c ON c.codpes = v.codpes
        WHERE v.tipvin = 'ALUNOGR'
            AND v.codclg = $codclg
            AND v.codcurgrd  IN ($curso)
            AND v.sitatl = 'A'
            AND v.dtainivin LIKE '%$ano%'
            ORDER BY v.nompes ASC";

        $ingressantes = DB::fetchAll($query_ingressantes);

        foreach($ingressantes as $i){
            $aux = [];
            $aux["Nome Aluno"] = $i["nompes"];
            $aux["Nusp"] = $i["codpes"];
            $query_questoes = "SELECT qp.codqtn , qp.dscqst  FROM fflch.dbo.QUESTOESPESQUISA qp inner join fflch.dbo.QUESTIONARIO q on qp.codqtn = q.codqtn
            where q.dtainiqtn <= '$ano-01-01'
            and q.dtafimqtn  >= '$ano-12-31'
            or q.nompsq like '%$ano%'";
            $questoes = DB::fetchAll($query_questoes);
            foreach($questoes as $q){
                $aux[$q['dscqst']] = "";
                if(stripos($q['dscqst'], 'sexo') !== false)
                    $aux[$q['dscqst']] = $q['dscatn'] ?? $i['sexpes'];
                else if((stripos($q['dscqst'], 'cor') !== false) || (stripos($q['dscqst'], 'raça') !== false)){
                    $aux[$q['dscqst']] = $q['dscatn'] ?? $i['codraccor'];
                }
            }
            $query_questionario = "SELECT q.codqtn, q.nompsq , qp.codqst ,  qp.dscqst ,  a.dscatn, r.dtarpa
            FROM fflch.dbo.RESPOSTASQUESTAO r
            inner join fflch.dbo.QUESTOESPESQUISA qp on qp.codqtn = r.codqtn and r.codqst = qp.codqst
            inner join fflch.dbo.ALTERNATIVAQUESTAO a on a.codqtn  = r.codqtn and a.codqst = r.codqst and a.numatnqst = r.numatnqst
            inner join fflch.dbo.QUESTIONARIO q on q.codqtn = r.codqtn
            where codpes = ".$i['codpes']." and qp.codqtn = " . (isset($questoes[0]['codqtn']) ? $questoes[0]['codqtn'] : 0);

            $questionario = DB::fetchAll($query_questionario);
            foreach($questionario as $q){
                    $aux[$q['dscqst']] = $q['dscatn'] ?? $q['dscqst'];
            }
            $aux["Data Resposta"] = isset($questionario[0]['dtarpa']) ? $questionario[0]['dtarpa'] :  '';

            $fuvest_qtnsocioecono[] = $aux;
        }
        return ($fuvest_qtnsocioecono);
    }

     /**
     * Método para retornar as iniciações científicas
     * Permite filtrar por departamento e por periodo.
     * @param array $departamento - Recebe um array com as siglas dos departamentos desejados. Se for igual a null, a consulta trazerá todos os departamentos.
     * @param int $ano_ini - ano inicial do período. Se for igual a null retorna todas as iniciações científicas.
     * @param int $ano_fim - ano final do período
     * @param bool $somenteAtivos - Se for igual a true retornará as iniciações científicas ativas
     * @return array
     */
    public static function listarIniciacaoCientifica($departamento = null, $ano_ini = null, $ano_fim = null, $somenteAtivos = false){
        $unidades = getenv('REPLICADO_CODUNDCLG');
        $query = "SELECT
        ic.codprj as cod_projeto,
        ic.codpesalu as aluno,
        p1.nompes as nome_aluno,
        p1.sexpes as genero_aluno,
        ic.titprj as titulo_pesquisa,
        ic.codpesrsp as orientador,
        p2.nompes as nome_orientador,
        p2.sexpes as genero_orientador,
        ic.dtainiprj as data_ini,
        ic.dtafimprj as data_fim,
        ic.anoprj as ano_projeto,
        s.nomset as departamento,
        s.nomabvset as sigla_departamento,
        ic.staprj as status_projeto
        from
        ICTPROJETO ic
        inner join
            PESSOA p1
            on p1.codpes = ic.codpesalu
        inner join
            PESSOA p2
            on p2.codpes = ic.codpesrsp
        inner join
            SETOR s ON s.codset = ic.codsetprj
        where
        ic.codundprj in (__unidades__)
        __data__
        __departamento__
        ORDER BY p1.nompes";

        $query = str_replace('__unidades__',$unidades,$query);

        $param = [];

        if($departamento != null && sizeof($departamento) > 0){
            if(is_array($departamento) && sizeof($departamento) > 1){
                $departamento = "'". implode("','", $departamento)."'";
            }else if(sizeof($departamento) == 1){
                $departamento = "'". $departamento[0] ."'";
            }
            $query = str_replace('__departamento__',"AND s.nomabvset in ($departamento)", $query);
        }else{
            $query = str_replace('__departamento__',"", $query);
        }
        if($ano_ini != -1 && $ano_ini != null && $ano_fim != null && !empty($ano_ini) && !empty($ano_fim)){
            $aux = " AND (ic.dtafimprj BETWEEN '".$ano_ini."-01-01' AND '".$ano_fim."-12-31' OR
                        ic.dtainiprj BETWEEN '".$ano_ini."-01-01' AND '".$ano_fim."-12-31') ";
            if($somenteAtivos){
                $aux .= " AND (ic.dtafimprj > GETDATE() or ic.dtafimprj IS NULL)";
            }
            $query = str_replace('__data__',$aux, $query);
        }else if($ano_ini == null && !$somenteAtivos){
            $query = str_replace('__data__','', $query);
        }else if($somenteAtivos){
            $query = str_replace('__data__',"AND (ic.dtafimprj > GETDATE() or ic.dtafimprj IS NULL)", $query);
        }
        $result =  DB::fetchAll($query, $param);

        $iniciacao_cientifica = [];
        foreach($result as $ic){
            $curso = Pessoa::retornarCursoPorCodpes($ic['aluno']);
            $ic['codcur'] =  $curso == null ? null : $curso['codcurgrd'];
            $ic['nome_curso'] =  $curso == null ? null : $curso['nomcur'];
            $query_com_autodeclaracao_cor = "SELECT  case codraccor
            when 1 then 'Indígena'
            when 2 then 'Branca'
            when 3 then 'Negra'
            when 4 then 'Amarela'
            when 5 then 'Parda'
            when 6 then 'Não informado'
            end as raca_cor_aluno from COMPLPESSOA where codpes = convert(int,:codpes)
            ";
            $param_com_autodeclaracao_cor = [
                'codpes' => $ic['aluno'],
            ];

            $result =  DB::fetch($query_com_autodeclaracao_cor, $param_com_autodeclaracao_cor);

            $ic['raca_cor_aluno'] = $result['raca_cor_aluno'] ?? 'Não informado';

            $query_com_bolsa = "SELECT b.codctgedi, b.dtainibol, b.dtafimbol FROM ICTPROJEDITALBOLSA b
            inner join ICTPROJETO i on (i.codprj = b.codprj and i.anoprj = b.anoprj)
            where codundprj in (__unidades__)
            and codmdl = 1
            and i.codpesalu  = convert(int,:codpes)
            and i.codprj = convert(int,:codprj)
            ";

            $query_com_bolsa = str_replace('__unidades__', $unidades, $query_com_bolsa);

            $param_com_bolsa = [
                'codpes' => $ic['aluno'],
                'codprj' => $ic['cod_projeto'],
            ];
            
            $result =  DB::fetchAll($query_com_bolsa, $param_com_bolsa);
            
            if(count($result) == 0){
                $ic['bolsa'] = 'false';
                $ic['codctgedi'] = '';
                $ic['dtainibol'] = null;
                $ic['dtafimbol'] = null;
            }else{
                $ic['bolsa'] = 'true';
                $ic['codctgedi'] = $result[0]['codctgedi'] == '1' ? 'PIBIC' : 'PIBITI';
                $ic['dtainibol'] = $result[0]['dtainibol'] ?? null;
                $ic['dtafimbol'] = $result[0]['dtafimbol'] ??  null;
            }

            array_push($iniciacao_cientifica, $ic);
        }
        return $iniciacao_cientifica;
    }

}
