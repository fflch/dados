 --Quantidade de alunos especiais de pós graduação, por ano:
SELECT COUNT(DISTINCT codpes) from VINCULOPESSOAUSP 
    where tipvin = 'ALUNOPOSESP' and codclg = 8 and dtainivin LIKE '%__ano__%'