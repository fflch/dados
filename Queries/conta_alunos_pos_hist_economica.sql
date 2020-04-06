SELECT COUNT (DISTINCT p.codpes) from VINCULOPESSOAUSP v 
INNER JOIN NOMEAREA n on v.codare = n.codare 
INNER JOIN LOCALIZAPESSOA p on v.codpes = p.codpes where v.sitatl = 'A' 
AND v.codclg = 8 and v.tipvin = 'ALUNOPOS' AND n.codare = 8137