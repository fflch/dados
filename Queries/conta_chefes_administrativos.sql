SELECT COUNT (DISTINCT LOCALIZAPESSOA.codpes)
from LOCALIZAPESSOA WHERE LOCALIZAPESSOA.tipvinext = 'Servidor Designado' 
AND LOCALIZAPESSOA.codpes IN (Select codpes from LOCALIZAPESSOA 
where LOCALIZAPESSOA.tipvinext = 'Servidor' and LOCALIZAPESSOA.codundclg = 8 and LOCALIZAPESSOA.sitatl = 'A') 