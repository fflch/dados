-- ALUNOS ATIVOS GRADUAÇÃO LETRAS
SELECT count (distinct l.codpes) FROM LOCALIZAPESSOA l
join SITALUNOATIVOGR s
on s.codpes = l.codpes 
WHERE l.tipvin = 'ALUNOGR' AND l.codundclg = 8 AND s.codcur in (8050, 8051, 8060)