SELECT  count(v.codpes) from VINCULOPESSOAUSP v
JOIN PESSOA p on p.codpes = v.codpes
WHERE v.tipvin IN ('ALUNOPOS', 'ALUNOPD')
AND v.codclg = 8
__nivpgm__
AND v.codare = __codare__
AND p.sexpes = '__genero__'
AND v.dtainivin LIKE '%__ano__%'