SELECT COUNT(DISTINCT l.codpes) 
FROM LOCALIZAPESSOA l
JOIN PESSOA p ON  p.codpes = l.codpes 
WHERE nomfnc LIKE '%Coord Cursos Grad%' AND p.sexpes = '__genero__'