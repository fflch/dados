SELECT 
	V.codpes AS NUSP,
	V.nompes AS Nome,
	CASE V.nivpgm
        WHEN 'ME' THEN 'Mestrado'
        WHEN 'DO' THEN 'Doutorado'
        WHEN 'DD' THEN  'Doutorado Direto'       
    END AS Nivel,
	NC.nomcur AS Curso
FROM fflch.dbo.VINCULOPESSOAUSP AS V
	INNER JOIN fflch.dbo.AREA AS A 
		ON A.codare = V.codare 
    INNER JOIN fflch.dbo.NOMECURSO AS NC 
    	ON A.codcur = NC.codcur and NC.dtafimcur is null
WHERE V.tipvin = 'ALUNOPOS'
	AND V.sitatl = 'A'
    AND V.codare IN (__area__)
ORDER BY V.codare