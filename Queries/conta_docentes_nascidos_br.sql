SELECT COUNT(lp.codpes)
FROM LOCALIZAPESSOA lp
    JOIN COMPLPESSOA cp
    ON lp.codpes = cp.codpes
WHERE lp.tipvinext = 'Docente'
    AND lp.sitatl = 'A'
    AND lp.codundclg = 8
    AND cp.codpasnas = 1 