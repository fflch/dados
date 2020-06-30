SELECT count (DISTINCT l.codpes)
FROM LOCALIZAPESSOA l
    JOIN VINCULOPESSOAUSP v
    ON l.codpes = v.codpes
WHERE l.tipvin IN ('ALUNOGR')
    AND l.codundclg = 8
    AND l.sitatl = 'A'
    AND v.tiping LIKE '__tipo__'