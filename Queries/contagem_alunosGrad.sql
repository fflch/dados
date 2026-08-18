SELECT c.nomcur, count(*) as qtd
from VINCULOPESSOAUSP v
INNER JOIN CURSOGR c 
ON v.codcurgrd = c.codcur
WHERE v.codfusclgund = 8 
and v.tipvin = 'ALUNOGR' 
and v.sitatl = 'A'
group by c.nomcur