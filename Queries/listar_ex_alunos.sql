SELECT DISTINCT E.codema, V.codpes, V.nompes, T.titpes
FROM TITULOPES T 
    INNER JOIN VINCULOPESSOAUSP V ON T.codpes = V.codpes
    LEFT JOIN EMAILPESSOA E ON T.codpes = E.codpes  
    WHERE T.codorg = 8 
    __nivel__
    AND E.staatnsen = 'S'
    ORDER BY T.dtatitpes DESC