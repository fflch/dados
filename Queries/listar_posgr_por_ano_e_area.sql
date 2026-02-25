SELECT DISTINCT 
	V.codpes AS NUSP,
	L.codema AS Email, 
	L.nompes AS Nome
FROM fflch.dbo.VINCULOPESSOAUSP AS V
	INNER JOIN fflch.dbo.AREA AS A 
		ON A.codare = V.codare 
    INNER JOIN fflch.dbo.CURSO AS C 
    	ON C.codcur = A.codcur
    INNER JOIN fflch.dbo.NOMECURSO AS NC 
    	ON C.codcur = NC.codcur       
 	INNER JOIN fflch.dbo.LOCALIZAPESSOA as L
    	ON (V.codpes = L.codpes)
WHERE V.tipvin = 'ALUNOPOS'
	AND V.sitatl = 'A'
    AND V.codare IN (__area__)
ORDER BY V.codare