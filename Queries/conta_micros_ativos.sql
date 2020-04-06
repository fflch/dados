SELECT COUNT(bp.numpat) FROM dbo.BEM b
INNER JOIN dbo.BEMPATRIMONIADO bp
ON b.codbem = bp.codbem 
WHERE (b.coditmmat = 9300 OR b.coditmmat = 45624 OR b.coditmmat = 51110 OR b.coditmmat = 57100 OR b.coditmmat = 61280  OR b.coditmmat = 354341  OR b.coditmmat = 355020) 
AND bp.stabem ='Ativo'
