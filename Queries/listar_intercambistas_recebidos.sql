SELECT DISTINCT p.nompesttd, v.codpes, v.dtainivin, v.dtafimvin
FROM VINCULOPESSOAUSP v
JOIN TIPOVINCULO t ON v.tipvin = t.tipvin
JOIN PESSOA p ON v.codpes = p.codpes
WHERE t.tipvin IN ('ALUNOICD', 'ALUNOCONVENIOINT')
AND codfusclgund = 8
ORDER BY dtainivin