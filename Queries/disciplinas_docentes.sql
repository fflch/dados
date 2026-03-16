SELECT DISTINCT
    S.nomset AS NomeDepartamento,
    V.tipmer AS MeritoDocente,
    M.codpes AS NUSP,
    V.nompes AS NomeDocente,
    COUNT(DISTINCT M.coddis + '-' + SUBSTRING(CONVERT(VARCHAR, M.codtur), 1, 5)) AS Disciplinas,
    COUNT(DISTINCT CONVERT(VARCHAR, M.coddis) + '-' + SUBSTRING(CONVERT(VARCHAR, M.codtur), 1, 5)) / __interval__.0 AS MediaDisciplinasAno
FROM fflch.dbo.MINISTRANTE M
INNER JOIN fflch.dbo.VINCULOPESSOAUSP V ON V.codpes = M.codpes
INNER JOIN fflch.dbo.SETOR S ON S.codset = V.codset AND (V.tipmer LIKE '%MS-5%' OR V.tipmer LIKE '%MS-6%' OR V.tipmer='NULL')
WHERE M.codpes IN ( __docentes__ )  
AND SUBSTRING(CONVERT(VARCHAR, M.codtur), 1, 5) IN (
    __semestres__
)
GROUP BY S.nomset, V.tipmer, M.codpes, V.nompes, V.codset
ORDER BY S.codset, V.tipmer DESC, V.nompes