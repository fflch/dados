SELECT p.sexpes, COUNT (DISTINCT l.codpes)
FROM LOCALIZAPESSOA l
    __join__  
    JOIN PESSOA p
    ON l.codpes = p.codpes
WHERE l.sitatl = 'A'
    AND l.codundclg = 8
    __condicao__
GROUP BY p.sexpes  
