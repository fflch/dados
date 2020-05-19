SELECT COUNT (DISTINCT l.codpes)
from LOCALIZAPESSOA l 
inner join PESSOA p on l.codpes = p.codpes WHERE
l.codpes IN (Select codpes from LOCALIZAPESSOA loc
where loc.tipvinext = 'Servidor' and loc.codundclg = 8 and loc.sitatl = 'A') 
AND l.tipvinext = 'Servidor Designado' AND p.sexpes = 'F'