--Quantidade de alunas que ingressaram no curso de Geografia 2010-2020
SELECT COUNT (distinct l.codpes) FROM fflch.dbo.VINCULOPESSOAUSP l
JOIN fflch.dbo.SITALUNOATIVOGR s
ON s.codpes = l.codpes 
JOIN fflch.dbo.PESSOA p
ON p.codpes = l.codpes 
WHERE l.tipvin = 'ALUNOGR' 
    AND l.codclg = 8 
    AND s.codcur = 8010
    AND p.sexpes = 'F'
    AND l.dtainivin LIKE '%__ano__%'