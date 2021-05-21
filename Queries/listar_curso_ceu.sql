SELECT C.codcurceu, C.codsetdep, S.nomset, C.nomcurceu, O.qtdvagofe, 
	C.dscpbcinr, C.objcur, C.juscur, C.fmtcurceu, O.dtainiofeatv, O.dtafimofeatv, 
	C.juscurensdtc, P.cgaminapralu, P.totcgahorpgm 
	from CURSOCEU C 
        INNER JOIN SETOR S ON C.codsetdep = S.codset 
        INNER JOIN OFERECIMENTOATIVIDADECEU O ON O.codcurceu = C.codcurceu 
        LEFT JOIN PROGRAMACURSOCEU P ON C.codcurceu = P.codcurceu 
        WHERE C.codclg = 8 
        __ano__
        AND C.codsetdep IN (__departamento__)
	ORDER BY C.dtainc ASC