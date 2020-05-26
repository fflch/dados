SELECT COUNT(lp.codpes)
FROM LOCALIZAPESSOA lp
    LEFT JOIN COMPLPESSOA cp
    ON lp.codpes = cp.codpes
WHERE lp.tipvin = 'ALUNOGR'
    AND lp.codundclg = 8
    AND cp.codpasnas = NULL