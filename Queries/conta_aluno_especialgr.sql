 --Quantidade de alunos especiais de graduação, por ano:
SELECT COUNT(DISTINCT codpes) from VINCULOPESSOAUSP 
    where tipvin = 'ALUNOESPGR' and codclg = 8 and dtainivin LIKE '%__ano__%'