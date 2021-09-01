SELECT COUNT (DISTINCT l.codpes)
    from LOCALIZAPESSOA l
    inner join AGPROGRAMA a on l.codpes = a.codpes
    WHERE l.tipvin = 'ALUNOPOS' 
    AND l.codundclg = 8 
    and a.nivpgm = 'DO'
