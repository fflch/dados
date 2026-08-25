SELECT DISTINCT 
V.codpes, V.nompes, S.nomset, V.tipmer, V.nomabvcla, V.nomabvfnc, V.sitatl, V.sitoco, 
convert(char(10), V.dtainivin, 103 ) as dtainivin, 
convert(char(10), V.dtafimvin, 103 ) as dtafimvin, 
convert(char(10), V.dtafimdctati, 103 ) as dtafimdctati, 
convert(char(10), P.dtanas, 103 ) as dtanas, 
convert(char(10), C.dtaflc, 103 ) as dtaflc
FROM VINCULOPESSOAUSP V
LEFT JOIN SETOR S
	ON S.codset = V.codset 
LEFT JOIN COMPLPESSOA C
	ON C.codpes = V.codpes
LEFT JOIN PESSOA P
	ON P.codpes = V.codpes
WHERE V.codfusclgund = 8
AND V.tipvin = 'SERVIDOR'
AND V.tipfnc = 'Docente'
__filtros__
ORDER BY V.codpes