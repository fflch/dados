SELECT DISTINCT
	CASE P.codare 
		WHEN 8138 THEN 'História Social'
		WHEN 8136 THEN 'Geografia Humana'
		WHEN 8134 THEN 'Antropologia Social' 
		WHEN 8147 THEN 'Inglês'
		WHEN 8132 THEN 'Sociologia'  
		WHEN 8131 THEN 'Ciência Política' 
	END AS Area, 
P.codpes AS NumeroUSPAluno, 
V.nompes AS NomeAluno,
L.codema AS EmailAluno,
	CASE P.nivpgm
        WHEN 'ME' THEN 'Mestrado'
        WHEN 'DO' THEN 'Doutorado'
        WHEN 'DD' THEN  'Doutorado Direto'       
        --ELSE 'valor_padrao'
    END AS Nivel,
CONVERT(VARCHAR(10), P.dtaselpgm, 23) AS DataSelecao,
CONVERT(VARCHAR(10), P.dtactaprzpgm, 23) AS DataInicioPrazo,
CONVERT(VARCHAR(10), P.dtalimpgm, 23) AS DataLimiteDeposito,
CONVERT(VARCHAR(10), P.dtadfapgm, 23) AS DataDefesa,
F.codpgmfom AS Fomento,
I.nomittfom  AS NFomento,
--	CASE
--	-	WHEN I.nomittfom IS NULL THEN NULL
---		WHEN I.nomittfom = 'Fundação de Amparo à Pesquisa do Estado de São Paulo' THEN 'FAPESP'
--		WHEN I.nomittfom = 'Coordenação de Aperfeiçoamento de Pessoal de Nível Superior' THEN 'CAPES'
--		WHEN I.nomittfom = 'Conselho Nacional de Desenvolvimento Científico e Tecnológico' THEN 'CNPq'
		--WHEN IS NULL THEN NULL
	-- ELSE I.nomittfom
--	END AS NomeFomento,
CONVERT(VARCHAR(10), F.dtainibol, 23) AS DataInicioFomento,
CONVERT(VARCHAR(10), F.dtafimbol, 23) AS DataFimFomento,
P.starcopgm AS 'Status'
FROM fflch.dbo.AGPROGRAMA P
	INNER JOIN fflch.dbo.VINCULOPESSOAUSP V 
		ON V.codpes = P.codpes
	INNER JOIN fflch.dbo.LOCALIZAPESSOA L
		ON L.codpes = P.codpes
	LEFT JOIN fflch.dbo.INSTITFOMENTOBOLSA F
		ON F.codpes = P.codpes AND F.numseqpgm = P.numseqpgm AND F.anosem IN (__ano__1, __ano__2) AND YEAR(F.dtafimbol) >= __ano__
	LEFT JOIN fflch.dbo.INSTITUICAOFOMENTO I
		ON I.codittfom = F.codittfom
WHERE P.codare IN (__area__)
	AND YEAR(dtalimpgm) >= __ano__
	AND YEAR(dtactaprzpgm) <= __ano__
	--AND dtactaprzpgm > '2024-12-31'
ORDER BY Area, NomeAluno