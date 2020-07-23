SELECT COUNT (DISTINCT b.codpes) from BENEFICIOALUCONCEDIDO b 
JOIN LOCALIZAPESSOA l 
ON b.codpes = l.codpes
WHERE b.codbnfalu = 42 and l.codundclg = 8 and b.dtafimccd LIKE '%2020%'