--Quantidade de alunos que ingressaram no curso de Filosofia 2010-2020
SELECT COUNT (distinct l.codpes) FROM VINCULOPESSOAUSP l
JOIN SITALUNOATIVOGR s
ON s.codpes = l.codpes 
JOIN PESSOA p
ON p.codpes = l.codpes 
WHERE l.tipvin = 'ALUNOGR' 
    AND l.codclg = 8 
    AND s.codcur = 8010
    AND p.sexpes = 'F'
    AND l.dtainivin LIKE '%__ano__%'