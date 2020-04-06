SELECT COUNT(bp.numpat) FROM dbo.BEM b
INNER JOIN dbo.BEMPATRIMONIADO bp
ON b.codbem = bp.codbem 
WHERE (b.coditmmat = 12513 OR b.coditmmat = 52744 OR b.coditmmat = 153214 OR b.coditmmat = 162213 OR b.coditmmat = 354384 OR b.coditmmat = 354562)
AND bp.stabem ='Ativo'
