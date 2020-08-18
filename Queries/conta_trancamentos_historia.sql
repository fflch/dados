SELECT count (distinct l.codpes)
FROM LOCALIZAPESSOA l
    JOIN SITALUNOATIVOGR s
    ON s.codpes = l.codpes
    JOIN PESSOA p
    ON p.codpes = l.codpes
WHERE l.tipvin = 'ALUNOGR'
    AND l.codundclg = 8
    AND s.codcur = 8030
    AND s.staalu = 'T'
    AND s.anosem = __semestre__