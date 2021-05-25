SELECT DISTINCT E.codema, P.nompes, T.titpes
FROM TITULOPES T 
	INNER JOIN PESSOA P ON T.codpes = P.codpes
    LEFT JOIN EMAILPESSOA E ON T.codpes = E.codpes  
    WHERE T.codorg = 8 
    AND T.codare IN (__area__)
    AND E.staatnsen = 'S'
    ORDER BY T.dtatitpes DESC