SELECT COUNT (p.sexpes) FROM LOCALIZAPESSOA l
JOIN PESSOA p
ON p.codpes = l.codpes 
WHERE l.tipvin = 'ALUNOGR' 
    AND l.codundclg = 8
	AND p.sexpes = 'F'
