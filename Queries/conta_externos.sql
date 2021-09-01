SELECT count(DISTINCT codpes) 
    FROM VINCULOPESSOAUSP v 
        where tipvin = 'EXTERNO' 
        and sitatl = 'A' 
        and codclg = 8