SELECT COUNT(l.codpes)
FROM LOCALIZAPESSOA l
    JOIN COMPLPESSOA c
    ON c.codpes = l.codpes
WHERE l.tipvin IN ('ALUNOGR', 'ALUNOCEU', 'ALUNOPOS', 'ALUNOPD')
    AND l.codundclg = 8
    AND l.sitatl = 'A'
    AND c.codraccor = __cor__