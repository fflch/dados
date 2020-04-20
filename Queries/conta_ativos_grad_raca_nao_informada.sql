SELECT COUNT(l.codpes)
FROM LOCALIZAPESSOA l
    JOIN COMPLPESSOA c
    ON c.codpes = l.codpes
WHERE l.tipvin = 'ALUNOGR'
    AND l.codundclg = 8
    AND (c.codraccor NOT IN (1, 2, 3, 4, 5)
    OR c.codraccor = NULL)