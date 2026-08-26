SELECT  
	proj.anoprj,
	proj.codprj,
	proj.titprj,
    proj.codpes_pd as 'nuspPd',
	proj.dtainiprj as 'inicioPrj',
	proj.dtafimprj as 'fimPrj',
	proj.staatlprj as 'status',
	proj.codsetprj as 'departamento',
	pd.numcpf as 'cpfPd',
	pd.nompesttd as 'nomePd',
	em.codema as 'emailPd',
	supem.codema as 'emailSup',
	suppes.numcpf as 'cpfSup',
	suppes.nompesttd as 'nomeSup' ,
	sup.codpesspv as 'nuspSup'
FROM PDPROJETO proj
LEFT JOIN PESSOA pd on proj.codpes_pd = pd.codpes
LEFT JOIN EMAILPESSOA em on proj.codpes_pd = em.codpes and em.stamtr = 'S'
LEFT JOIN PDPROJETOSUPERVISOR sup on proj.anoprj = sup.anoprj and proj.codprj = sup.codprj and numseqspv = 1
LEFT JOIN EMAILPESSOA supem on sup.codpesspv = supem.codpes and supem.stamtr = 'S'
LEFT JOIN PESSOA suppes on sup.codpesspv = suppes.codpes 
WHERE proj.codmdl = 2  
__filtros__