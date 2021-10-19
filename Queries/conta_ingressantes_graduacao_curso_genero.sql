SELECT COUNT (distinct l.codpes) FROM fflch.dbo.VINCULOPESSOAUSP l
JOIN fflch.dbo.SITALUNOATIVOGR s
ON s.codpes = l.codpes 
JOIN fflch.dbo.PESSOA p
ON p.codpes = l.codpes 
WHERE l.tipvin = 'ALUNOGR' 
    AND l.codclg = 8 
    AND s.codcur IN (__codcur__)
    AND p.sexpes = '__genero__'
    AND l.dtainivin LIKE '%__ano__%'