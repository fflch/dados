SELECT COUNT(bp.numpat) FROM dbo.BEM b
INNER JOIN dbo.BEMPATRIMONIADO bp
ON b.codbem = bp.codbem 
WHERE b.coditmmat = 162213 AND bp.stabem ='Ativo'
