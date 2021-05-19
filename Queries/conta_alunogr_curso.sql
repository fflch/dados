SELECT count (distinct l.codpes) FROM LOCALIZAPESSOA l
join SITALUNOATIVOGR s
on s.codpes = l.codpes 
WHERE l.tipvin = 'ALUNOGR' AND l.codundclg = 8 AND s.codcur = __curso__