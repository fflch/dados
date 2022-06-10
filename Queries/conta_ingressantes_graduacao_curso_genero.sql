SELECT COUNT (distinct v.codpes) FROM VINCULOPESSOAUSP v
JOIN SITALUNOATIVOGR s
ON s.codpes = v.codpes AND  s.codcur = v.codcurgrd 
JOIN PESSOA p
ON p.codpes = v.codpes 
WHERE v.tipvin = 'ALUNOGR' 
    AND v.codclg = 8 
    AND s.codcur IN (__codcur__)
    AND p.sexpes = '__genero__'
    AND v.dtainivin LIKE '%__ano__%'