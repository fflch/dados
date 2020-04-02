-- Alunos de Pos-Doutorado ativos com programa ativo
SELECT COUNT(DISTINCT l.codpes) FROM dbo.LOCALIZAPESSOA l INNER JOIN
dbo.PDPROJETO p ON (l.codpes = p.codpes_pd)
WHERE l.sitatl = 'A' AND l.tipvin = 'ALUNOPD' AND l.codundclg = 8 AND p.staatlprj = 'Ativo' AND p.codsetprj IN (592, 599, 600, 601, 603)

