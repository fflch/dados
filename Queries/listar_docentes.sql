SELECT DISTINCT 
V.codpes, V.nompes, S.nomset, V.tipmer, V.nomabvcla, V.nomabvfnc, V.sitatl, V.sitoco, V.dtafimvin, V.dtafimdctati
FROM fflch.dbo.VINCULOPESSOAUSP V
INNER JOIN fflch.dbo. SETOR S
	ON S.codset = V.codset 
WHERE V.codfusclgund = 8
AND V.tipvin = 'SERVIDOR'
AND V.nomcaa = 'Docente'
AND V.codset IN (__departamentos__)
__filtros__
ORDER BY V.codpes