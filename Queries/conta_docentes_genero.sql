SELECT COUNT (p.sexpes)
FROM LOCALIZAPESSOA l
    JOIN PESSOA p
    ON p.codpes = l.codpes
WHERE l.tipvinext LIKE 'Docente'
    AND l.codundclg = 8
    AND l.sitatl = 'A'
    AND p.sexpes = '__genero__'