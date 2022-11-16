SELECT p.sglest, COUNT (DISTINCT l.codpes)
FROM LOCALIZAPESSOA l 
    INNER JOIN PESSOA p ON l.codpes = p.codpes 
WHERE l.tipvin IN ('ALUNOGR', 'ALUNOCEU', 'ALUNOPOS', 'ALUNOPD') 
    AND l.sitatl = 'A'
    AND l.codundclg = 8
GROUP BY p.sglest