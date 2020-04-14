SELECT COUNT (DISTINCT v.codpes) 
FROM VINCULOPESSOAUSP v
    JOIN TITULOPES t
    ON v.codpes = t.codpes
WHERE v.tipvin = 'ALUNOPOS'
    AND v.dtafimvin LIKE '%2017%'
    AND v.sitoco LIKE 'Conclu%' -- consulta não funciona com acento
    AND v.codclg = 8
    AND t.codare in (8131, 8132, 8133, 8134, 8135, 8136, 8137, 
 8138, 8139, 8142, 8143, 8144, 8145, 8146, 8147, 8148, 8149, 
 8150, 8151, 8155, 8156, 8157, 8158, 8159, 8160, 8161, 8165)