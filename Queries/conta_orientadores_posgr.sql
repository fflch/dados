SELECT COUNT(DISTINCT r.codpes) 
FROM R25CRECREDOC as r
JOIN LOCALIZAPESSOA as l
    ON r.codpes = l.codpes
    WHERE r.codare = __area__
    AND l.sitatl = 'A'
    AND l.codundclg = 8
    AND r.dtavalfim > getdate()