SELECT COUNT (bc.dtainiccd )
FROM BENEFICIOALUCONCEDIDO bc
    JOIN LOCALIZAPESSOA l
    ON l.codpes = bc.codpes
WHERE bc.dtainiccd LIKE '%2018%' AND l.codundclg = 8