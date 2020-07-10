SELECT count ( b.codpes)
FROM LOCALIZAPESSOA l
    join fflch.dbo.BENEFICIOALUCONCEDIDO b
    on b.codpes = l.codpes
where b.tipvin IN ('ALUNOGR')
    and b.codbnfalu = __codigo__
    and b.anoofebnf in (2020, 20201, 20202)