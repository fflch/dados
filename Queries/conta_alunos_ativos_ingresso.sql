SELECT
    __select__
FROM LOCALIZAPESSOA l
    JOIN VINCULOPESSOAUSP v
    ON (l.codpes = v.codpes AND l.tipvin = v.tipvin)
WHERE l.codundclg = 8
    AND v.sitatl = 'A'
    AND v.tipvin = 'ALUNOGR'
GROUP BY v.tiping