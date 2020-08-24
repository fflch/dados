SELECT COUNT (DISTINCT l.codpes)
FROM LOCALIZAPESSOA l
    INNER JOIN PESSOA p
    ON l.codpes = p.codpes
WHERE l.tipvin = 'ALUNOCEU'
    AND l.codundclg = 8
    AND p.sexpes = '__genero__'