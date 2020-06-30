 --Quantidade de alunos que receberam benefício, por ano:
SELECT COUNT(DISTINCT p.codpes)
FROM PESSOA p
JOIN BENEFICIOALUCONCEDIDO bac
ON p.codpes = bac.codpes
WHERE bac.dtainiccd LIKE '%__ano__%'