SELECT count ( b.codpes)
FROM LOCALIZAPESSOA l
    join BENEFICIOALUCONCEDIDO b
    on b.codpes = l.codpes
where b.tipvin IN ('ALUNOGR')
    and b.codbnfalu = __codigo__
    and b.anoofebnf in (__ano__) 