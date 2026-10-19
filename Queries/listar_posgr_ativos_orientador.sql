SELECT 
	V.codpes AS NUSP,
	L.codema AS Email, 
	L.nompes AS Nome,
	CASE V.nivpgm
        WHEN 'ME' THEN 'Mestrado'
        WHEN 'DO' THEN 'Doutorado'
        WHEN 'DD' THEN  'Doutorado Direto'       
    END AS Nivel,
	NC.nomcur AS Curso,
	ori.codpes AS OrientadorNUSP,
	oriPes.nompesttd AS Orientador
FROM fflch.dbo.VINCULOPESSOAUSP AS V
	INNER JOIN fflch.dbo.AREA AS A 
		ON A.codare = V.codare 
    INNER JOIN fflch.dbo.NOMECURSO AS NC 
    	ON A.codcur = NC.codcur and NC.dtafimcur is null
 	INNER JOIN fflch.dbo.LOCALIZAPESSOA as L
    	ON (V.codpes = L.codpes)
	LEFT JOIN R39PGMORIDOC as ori
		ON V.codpes = ori.codpespgm and V.numseqpgm = ori.numseqpgm and ori.dtafimort is null and ori.tiport != 'COO'
	LEFT JOIN PESSOA as oriPes
		ON oriPes.codpes = ori.codpes
WHERE V.tipvin = 'ALUNOPOS'
	AND V.sitatl = 'A'
	AND L.tipvin = 'ALUNOPOS'
    AND V.codare IN (__area__)
ORDER BY V.codare