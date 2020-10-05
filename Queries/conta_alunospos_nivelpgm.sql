SELECT COUNT(lp.codpes) FROM LOCALIZAPESSOA AS lp
    INNER JOIN VINCULOPESSOAUSP AS vpu
        ON(lp.codpes = vpu.codpes AND lp.tipvin = vpu.tipvin)
    WHERE lp.tipvin='ALUNOPOS' 
        AND lp.codundclg= 8
        AND lp.sitatl= 'A'
        AND vpu.nivpgm = '__nivel__'