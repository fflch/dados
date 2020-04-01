SELECT COUNT (p.sexpes) FROM LOCALIZAPESSOA l
JOIN PESSOA p
ON p.codpes = l.codpes 
WHERE l.tipvin = 'ALUNOPOS' 
    AND l.codundclg = 8
	AND p.sexpes = 'M'