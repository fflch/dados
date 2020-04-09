SELECT COUNT (DISTINCT l.codpes)
FROM LOCALIZAPESSOA l 
JOIN PESSOA p 
ON p.codpes = l.codpes 
WHERE p.sexpes = 'F' AND l.tipvin = 'ALUNOPD'