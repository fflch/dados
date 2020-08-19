 --Quantidade de alunos especiais de graduação no ano de 2020 (ativos):
SELECT COUNT(DISTINCT codpes) from VINCULOPESSOAUSP 
    where tipvin = 'ALUNOESPGR' and codclg = 8 and dtainivin LIKE '%2020%' and sitatl = 'A'