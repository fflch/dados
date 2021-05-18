SELECT COUNT(lp.codpes)
FROM fflch.dbo.LOCALIZAPESSOA lp
    LEFT JOIN fflch.dbo.COMPLPESSOA cp
    ON lp.codpes = cp.codpes
WHERE lp.tipvin = '__vinculo__'
    AND lp.codundclg = 8
    __codpasnas__
