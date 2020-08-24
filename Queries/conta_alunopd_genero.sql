SELECT COUNT (DISTINCT l.codpes)
FROM LOCALIZAPESSOA l
    JOIN PESSOA p
    ON p.codpes = l.codpes
WHERE p.sexpes = '__genero__'
    AND l.tipvin = 'ALUNOPD'