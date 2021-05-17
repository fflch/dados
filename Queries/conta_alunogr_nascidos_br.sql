SELECT COUNT(lp.codpes)
FROM LOCALIZAPESSOA lp
    LEFT JOIN COMPLPESSOA cp
    ON lp.codpes = cp.codpes
WHERE lp.tipvinext = '__vinculo__'
    AND lp.codundclg = 8
    AND cp.codpasnas = 1