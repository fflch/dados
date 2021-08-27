SELECT COUNT(L.codpes) FROM LOCALIZAPESSOA L
JOIN PESSOA P ON L.codpes = P.codpes 
	WHERE L.nomfnc = 'Ch Depart Ensino' 
	AND L.codundclg = 8 
	AND L.sitatl = 'A'
	AND P.sexpes = '__genero__'