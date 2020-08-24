SELECT COUNT(l.codpes)
FROM LOCALIZAPESSOA l
    INNER JOIN PESSOA p
    ON l.codpes = p.codpes
WHERE l.tipvinext = 'Servidor'
    AND codundclg = 8
    AND sitatl = 'A'
    AND p.sexpes = '__genero__'