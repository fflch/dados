SELECT COUNT (DISTINCT l.codpes)
FROM LOCALIZAPESSOA l
    __join_alunogr__  
    JOIN PESSOA p
    ON l.codpes = p.codpes
WHERE l.tipvin = '__tipvin__' 
    AND l.codundclg = 8
    AND p.sexpes = '__genero__'
    __curso__  
