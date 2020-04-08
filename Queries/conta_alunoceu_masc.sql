SELECT COUNT (DISTINCT l.codpes) from LOCALIZAPESSOA l
INNER JOIN PESSOA p
ON l.codpes = p.codpes
where l.tipvin = 'ALUNOCEU' and l.codundclg = 8 and p.sexpes = 'M'

