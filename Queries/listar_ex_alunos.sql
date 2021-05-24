SELECT DISTINCT E.codema, P.nompes, T.titpes
FROM TITULOPES T 
	INNER JOIN PESSOA P ON T.codpes = P.codpes
    INNER JOIN EMAILPESSOA E ON T.codpes = E.codpes  
    WHERE T.codorg = 8 
    AND T.codcur IN (__curso__)
    AND E.staatnsen = 'S'
    ORDER BY T.dtatitpes DESC