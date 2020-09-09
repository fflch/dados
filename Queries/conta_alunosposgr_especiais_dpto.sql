SELECT COUNT(DISTINCT l.codpes) from VINCULOPESSOAUSP v 
    INNER JOIN NOMEAREA n on v.codare = n.codare 
    INNER JOIN LOCALIZAPESSOA l on v.codpes = l.codpes 
    where v.sitatl = 'A' AND v.codclg = 8 and v.tipvin = 'ALUNOPOSESP' AND n.codare = __dpto__