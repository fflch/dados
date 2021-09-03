SELECT COUNT (DISTINCT l.codpes)
from LOCALIZAPESSOA l
WHERE l.tipvin = 'ALUNOPD' 
    AND l.codundclg = 8 
