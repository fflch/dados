--Retorna a quantidade de professores doutores em cada departamento
SELECT COUNT(DISTINCT codpes) 
    FROM LOCALIZAPESSOA 
        WHERE tipvinext = 'Docente' AND codundclg = 8 and nomfnc = 'Prof Doutor' AND nomabvset = '__departamento__'
