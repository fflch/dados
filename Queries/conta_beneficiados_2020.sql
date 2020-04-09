 --Quantidade de alunos que receberam benefício em 2020:
SELECT COUNT(DISTINCT l.codpes)
FROM LOCALIZAPESSOA l
JOIN BENEFICIOALUCONCEDIDO bac
ON l.codpes = bac.codpes
WHERE bac.dtainiccd LIKE '%2020%' and l.codundclg = 8