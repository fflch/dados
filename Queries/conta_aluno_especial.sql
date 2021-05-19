 --Quantidade de alunos especiais de graduação e pós, por ano:
SELECT COUNT(DISTINCT codpes) from VINCULOPESSOAUSP 
    WHERE tipvin = '__aluno__' 
    AND codclg = 8 AND dtainivin LIKE '%__ano__%'