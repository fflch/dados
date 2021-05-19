SELECT COUNT (DISTINCT v.codpes)
FROM VINCULOPESSOAUSP v
    JOIN TITULOPES t
    ON v.codpes = t.codpes
WHERE v.tipvin = '__vinculo__'
    AND v.dtafimvin LIKE '%__ano__%'
    AND v.sitoco LIKE 'Conclu%' -- consulta não funciona com acento
    AND v.codclg = 8
    AND t.codcur IN (8010, 8021, 8030, 8040, 8050, 8051, 8060)
    