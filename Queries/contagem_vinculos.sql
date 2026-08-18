SELECT tipvinext,
	count(distinct codpes) AS qtd
FROM LOCALIZAPESSOA l
WHERE l.codundclg = 8
and sitatl = 'A'
and tipvin in ('SERVIDOR','ALUNOPOS')
group by tipvinext