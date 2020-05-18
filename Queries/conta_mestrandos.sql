SELECT COUNT (DISTINCT l.codpes)
from LOCALIZAPESSOA l
inner join AGPROGRAMA a
on l.codpes = a.codpes 
WHERE l.tipvin = 'ALUNOPOS' and l.sitatl = 'A' and a.nivpgm = 'ME' and l.codundclg = 8
