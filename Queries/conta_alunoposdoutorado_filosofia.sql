-- Alunos de Pos-Doutorado ativos com programa ativo do departmento de História
SELECT COUNT(DISTINCT l.codpes) FROM dbo.LOCALIZAPESSOA l INNER JOIN
dbo.PDPROJETO p ON (l.codpes = p.codpes_pd)
WHERE l.sitatl = 'A' AND l.tipvin = 'ALUNOPD' AND l.codundclg = 8 AND p.staatlprj = 'Ativo' AND p.codsetprj = 594

