SELECT DISTINCT
    S.nomset AS NomeDepartamento,
    V.tipmer AS MeritoDocente,
    M.codpes AS NUSP,
    V.nompes AS NomeDocente,
    M.coddis AS Disciplina,
    M.codtur AS Turma
FROM fflch.dbo.MINISTRANTE M
INNER JOIN fflch.dbo.VINCULOPESSOAUSP V ON V.codpes = M.codpes
INNER JOIN fflch.dbo.SETOR S ON S.codset = V.codset AND (V.tipmer LIKE '%MS-5%' OR V.tipmer LIKE '%MS-6%' OR V.tipmer='NULL')
WHERE M.codpes IN ( __docentes__ )  
AND SUBSTRING(CONVERT(VARCHAR, M.codtur), 1, 5) IN (
    __semestres__
)
ORDER BY S.codset, V.tipmer DESC, V.nompes