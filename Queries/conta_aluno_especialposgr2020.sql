 --Quantidade de alunos especiais de pós graduação no ano de 2020 (ativos):
SELECT COUNT(DISTINCT codpes) from VINCULOPESSOAUSP 
    where tipvin = 'ALUNOPOSESP' and codclg = 8 and dtainivin LIKE '%2020%' and sitatl = 'A'