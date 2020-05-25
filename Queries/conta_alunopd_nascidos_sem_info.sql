SELECT COUNT(lp.codpes)
FROM LOCALIZAPESSOA lp
    LEFT JOIN COMPLPESSOA cp
    ON lp.codpes = cp.codpes
WHERE lp.tipvin = 'ALUNOPD'
    AND lp.codundclg = 8
    AND cp.codpasnas = NULL