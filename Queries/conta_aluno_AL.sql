SELECT COUNT (DISTINCT l.codpes) from LOCALIZAPESSOA l 
INNER JOIN PESSOA p 
ON l.codpes = p.codpes 
WHERE l.tipvin IN ('ALUNOGR', 'ALUNOCEU', 'ALUNOPOS', 'ALUNOPD') and l.sitatl = 'A' AND p.sglest = 'AL'