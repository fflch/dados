<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProgramaController;
use App\Http\Controllers\DefesaController;

use App\Http\Controllers\IndexController, App\Http\Controllers\AtivosController, App\Http\Controllers\AtivosPorCursoGradController,
App\Http\Controllers\AtivosMicrosNotesController, App\Http\Controllers\AtivosPorGeneroGradController, 
App\Http\Controllers\AtivosPorGeneroPosController, App\Http\Controllers\AtivosPorGeneroDocentesController, 
App\Http\Controllers\AtivosPorGeneroEstagiariosController, App\Http\Controllers\AtivosPorGeneroFuncionariosController,
App\Http\Controllers\AtivosPosDoutoradoPorCursoController, App\Http\Controllers\AtivosPorDepartamentoFuncionariosController, 
App\Http\Controllers\AtivosPorProgramaPósController, App\Http\Controllers\AtivosPorGeneroCursoGradSociaisController, 
App\Http\Controllers\AtivosPorGeneroCursoGradFilosofiaController, App\Http\Controllers\AtivosPorGeneroCursoGradGeografiaController,
App\Http\Controllers\AtivosPorGeneroCursoGradHistoriaController, App\Http\Controllers\AtivosPorGeneroCursoGradLetrasController, 
App\Http\Controllers\BeneficiadosController, App\Http\Controllers\BeneficiosConcedidosHistoricoController, App\Http\Controllers\Beneficios2019PorProgramaController, 
App\Http\Controllers\AtivosPorGeneroCEUController, App\Http\Controllers\ConcluintesGradPorAnoController, App\Http\Controllers\AtivosPorGeneroPDController, 
App\Http\Controllers\ConcluintesGradPorCursoController, App\Http\Controllers\ConcluintesPosPorAnoController, App\Http\Controllers\ConveniosAtivosController, 
App\Http\Controllers\AutodeclaradosGraducaoController, App\Http\Controllers\AutodeclaradosPosController, App\Http\Controllers\AutodeclaradosCeuController, 
App\Http\Controllers\AtivosPorGeneroChefesAdministrativosController, App\Http\Controllers\AtivosGradPaisNascimentoController, App\Http\Controllers\AtivosPosPaisNascimentoController, 
App\Http\Controllers\AtivosDocentesPaisNascimentoController, App\Http\Controllers\AtivosCeuPaisNascimentoController, App\Http\Controllers\AtivosPDPaisNascimentoController, 
App\Http\Controllers\AtivosGradPorEstadoController, App\Http\Controllers\AtivosDocentesPorFuncaoController, App\Http\Controllers\AlunosAtivosAutodeclaradosController,
App\Http\Controllers\AlunosAtivosGradTipoIngressoController, App\Http\Controllers\BeneficiosAtivosGraduacao2020Controller, App\Http\Controllers\AtivosBolsaLivroController, 
App\Http\Controllers\TrancamentosCursoSemestralController, App\Http\Controllers\TrancamentosSociaisSemestralController, App\Http\Controllers\TrancamentosFilosofiaSemestralController, App\Http\Controllers\TrancamentosGeografiaSemestralController, 
App\Http\Controllers\TrancamentosHistoriaSemestralController, App\Http\Controllers\TrancamentosLetrasSemestralController, App\Http\Controllers\AlunosEspeciaisPosGrAnoController, 
App\Http\Controllers\AlunosEspeciaisGrAnoController, App\Http\Controllers\AlunosEspeciaisPosGrDptoController, App\Http\Controllers\IngressantesMasculinoGeoController,
App\Http\Controllers\IngressantesFemininoGeoController, App\Http\Controllers\AtivosPosNivelProgramaController, App\Http\Controllers\OrientadoresPosGRContoller, 
App\Http\Controllers\CoordCursosGradGeneroController, App\Http\Controllers\IngressantesFemininoLetrasController, App\Http\Controllers\IngressantesMasculinoLetrasController,
App\Http\Controllers\IngressantesFemininoFilosofiaController, App\Http\Controllers\IngressantesMasculinoFilosofiaController, App\Http\Controllers\IngressantesMasculinoHistoriaController,
App\Http\Controllers\IngressantesFemininoHistoriaController, App\Http\Controllers\IngressantesFemininoSociaisController, App\Http\Controllers\IngressantesMasculinoSociaisController,
App\Http\Controllers\AtivosProfTitularPorDptoController, App\Http\Controllers\AtivosProfDoutorPorDptoController, App\Http\Controllers\AtivosProfAssociadoPorDptoController,
App\Http\Controllers\ExAlunosController;

Route::get('/', [IndexController::class, 'index']);

# totais com vínculos ativos
Route::get('/ativos', [AtivosController::class, 'grafico']);
Route::get('/ativos/export/{format}', [AtivosController::class, 'export']);

# totais com vínculos ativos da graduação, separados por curso
Route::get('/ativosPCGrad', [AtivosPorCursoGradController::class, 'grafico']);
Route::get('/ativosPCGrad/export/{format}', [AtivosPorCursoGradController::class, 'export']);

# totais de microcomputadores e notebooks ativos
Route::get('/ativosMicrosNotes', [AtivosMicrosNotesController::class, 'grafico']);
Route::get('/ativosMicrosNotes/export/{format}', [AtivosMicrosNotesController::class, 'export']);

# totais de alunos da graduação, por gênero
Route::get('/ativosPGGrad', [AtivosPorGeneroGradController::class, 'grafico']);
Route::get('/ativosPGGrad/export/{format}', [AtivosPorGeneroGradController::class, 'export']);

# totais de alunos da pós graduação, por gênero
Route::get('/ativosPGPos', [AtivosPorGeneroPosController::class, 'grafico']);
Route::get('/ativosPGPos/export/{format}', [AtivosPorGeneroPosController::class, 'export']);

# totais de docentes, por gênero
Route::get('/ativosPGDocentes', [AtivosPorGeneroDocentesController::class, 'grafico']);
Route::get('/ativosPGDocentes/export/{format}', [AtivosPorGeneroDocentesController::class, 'export']);

# totais de estagiários, por gênero
Route::get('/ativosEstagiarios', [AtivosPorGeneroEstagiariosController::class, 'grafico']);
Route::get('/ativosEstagiarios/export/{format}', [AtivosPorGeneroEstagiariosController::class, 'export']);

# totais de funcionários, por gênero
Route::get('/ativosFuncionarios', [AtivosPorGeneroFuncionariosController::class, 'grafico']);
Route::get('/ativosFuncionarios/export/{format}', [AtivosPorGeneroFuncionariosController::class, 'export']);

# totais de alunos de pós-doutorado com programa ativo por curso
Route::get('/ativosPosDoutPorCurso', [AtivosPosDoutoradoPorCursoController::class, 'grafico'])->name('ativosposdoutoradocurso');
Route::get('/ativosPosDoutPorCurso/export/{format}', [AtivosPosDoutoradoPorCursoController::class, 'export'])->name('ativosposdoutoradocurso/export/{format}');

# totais de funcionários, por departamento
Route::get('/ativosFuncionariosDepartamento', [AtivosPorDepartamentoFuncionariosController::class, 'grafico']);
Route::get('/ativosFuncionariosDepartamento/export/{format}', [AtivosPorDepartamentoFuncionariosController::class, 'export']);

# totais de alunos da pós graduação, por programa
Route::get('/ativosPorProgramaPos', [AtivosPorProgramaPósController::class, 'grafico']);
Route::get('/ativosPorProgramaPos/export/{format}', [AtivosPorProgramaPósController::class, 'export']);

# totais de alunos da graduação em sociais por gênero
Route::get('/ativosGradSociais', [AtivosPorGeneroCursoGradSociaisController::class, 'grafico']);
Route::get('/ativosGradSociais/export/{format}', [AtivosPorGeneroCursoGradSociaisController::class, 'export']);

# totais de alunos da graduação em filosofia por gênero
Route::get('/ativosGradFilosofia', [AtivosPorGeneroCursoGradFilosofiaController::class, 'grafico']);
Route::get('/ativosGradFilosofia/export/{format}', [AtivosPorGeneroCursoGradFilosofiaController::class, 'export']);

# totais de alunos da graduação em geografia por gênero
Route::get('/ativosGradGeografia', [AtivosPorGeneroCursoGradGeografiaController::class, 'grafico']);
Route::get('/ativosGradGeografia/export/{format}', [AtivosPorGeneroCursoGradGeografiaController::class, 'export']);

# totais de alunos da graduação em história por gênero
Route::get('/ativosGradHistoria', [AtivosPorGeneroCursoGradHistoriaController::class, 'grafico']);
Route::get('/ativosGradHistoria/export/{format}', [AtivosPorGeneroCursoGradHistoriaController::class, 'export']);

# totais de alunos da graduação em Letras por gênero
Route::get('/ativosGradLetras', [AtivosPorGeneroCursoGradLetrasController::class, 'grafico']);
Route::get('/ativosGradLetras/export/{format}', [AtivosPorGeneroCursoGradLetrasController::class, 'export']);

# totais com algum benefício ativo
Route::get('/beneficiados', [BeneficiadosController::class, 'grafico']);
Route::get('/beneficiados/export/{format}', [BeneficiadosController::class, 'export']);

# série histórica de benefícios concedidos
Route::get('/ativosBeneficiosConHist', [BeneficiosConcedidosHistoricoController::class, 'grafico']);
Route::get('/ativosBeneficiosConHist/export/{format}', [BeneficiosConcedidosHistoricoController::class, 'export']);

# benefícios concedidos em 2019, por programa
Route::get('/Benef2019Prog', [Beneficios2019PorProgramaController::class, 'grafico']);
Route::get('/Benef2019Prog/export/{format}', [Beneficios2019PorProgramaController::class, 'export']);

# totais de alunos de cultura e extensão por gênero
Route::get('/ativosCulturaExtensao', [AtivosPorGeneroCEUController::class, 'grafico']);
Route::get('/ativosCulturaExtensao/export/{format}', [AtivosPorGeneroCEUController::class, 'export']);

# série histórica de concluintes da graduação
Route::get('/concluintesGradPorAno', [ConcluintesGradPorAnoController::class, 'grafico']);
Route::get('/concluintesGradPorAno/export/{format}', 'ConcluintesGradPorAnoController@export');

# totais de alunos pós-doutorando por gênero
Route::get('/ativosPosDoutorado', [AtivosPorGeneroPDController::class, 'grafico']);
Route::get('/ativosPosDoutorado/export/{format}', [AtivosPorGeneroPDController::class, 'export']);

# concluintes da graduação em {ano}, por curso
Route::get('/concluintesGradPorCurso/{ano}', [ConcluintesGradPorCursoController::class, 'grafico']);
Route::get('/concluintesGradPorCurso/export/{format}/{ano}', [ConcluintesGradPorCursoController::class, 'export']);

# série histórica de concluintes da pós-graduação
Route::get('/concluintesPosPorAno', [ConcluintesPosPorAnoController::class, 'grafico']);
Route::get('/concluintesPosPorAno/export/{format}', [ConcluintesPosPorAnoController::class, 'export']);

# totais de convênios ativos
Route::get('/conveniosAtivos', [ConveniosAtivosController::class, 'grafico']);
Route::get('/conveniosAtivos/export/{format}', [ConveniosAtivosController::class, 'export']);

# totais com vínculos ativos da graduação, separados por cor/raça
Route::get('/autodeclaradosGradAtivos', [AutodeclaradosGraducaoController::class, 'grafico']);
Route::get('/autodeclaradosGradAtivos/export/{format}', [AutodeclaradosGraducaoController::class, 'export']);

# totais com vínculos ativos da pós-graduação, separados por cor/raça
Route::get('/autodeclaradosPosAtivos', [AutodeclaradosPosController::class, 'grafico']);
Route::get('/autodeclaradosPosAtivos/export/{format}', [AutodeclaradosPosController::class, 'export']);

# totais com vínculos ativos da cultura e extensão universitária, separados por cor/raça
Route::get('/autodeclaradosCeuAtivos', [AutodeclaradosCeuController::class, 'grafico']);
Route::get('/autodeclaradosCeuAtivos/export/{format}', [AutodeclaradosCeuController::class, 'export']);

#totais de chefes administrativos ativos por gênero
Route::get('/ativosChefesAdministrativos', [AtivosPorGeneroChefesAdministrativosController::class, 'grafico']);
Route::get('/ativosChefesAdministrativos/export/{format}', [AtivosPorGeneroChefesAdministrativosController::class, 'export']);

#totais de alunos ativos da graduação nascidos e não nascidos no br
Route::get('/ativosGradPaisNasc', [AtivosGradPaisNascimentoController::class, 'grafico']);
Route::get('/ativosGradPaisNasc/export/{format}', [AtivosGradPaisNascimentoController::class, 'export']);

#totais de alunos ativos da pós graduação nascidos e não nascidos no br
Route::get('/ativosPosPaisNasc', [AtivosPosPaisNascimentoController::class, 'grafico']);
Route::get('/ativosPosPaisNasc/export/{format}', [AtivosPosPaisNascimentoController::class, 'export']);

#totais de docentes ativos nascidos e não nascidos no br
Route::get('/ativosDocentesPaisNasc', [AtivosDocentesPaisNascimentoController::class, 'grafico']);
Route::get('/ativosDocentesPaisNasc/export/{format}', [AtivosDocentesPaisNascimentoController::class, 'export']);

#totais de alunos ativos de cultura e extensão universitária nascidos e não nascidos no br
Route::get('/ativosCeuPaisNasc', [AtivosCeuPaisNascimentoController::class, 'grafico']);
Route::get('/ativosCeuPaisNasc/export/{format}', [AtivosCeuPaisNascimentoController::class, 'export']);

#totais de alunos ativos pós doutorado nascidos e não nascidos no br
Route::get('/ativosPDPaisNasc', [AtivosPDPaisNascimentoController::class, 'grafico']);
Route::get('/ativosPDPaisNasc/export/{format}', [AtivosPDPaisNascimentoController::class, 'export']);

#totais de alunos da Graduação por estado (RG)
Route::get('/ativosAlunosEstado', [AtivosGradPorEstadoController::class, 'grafico']);
Route::get('/ativosAlunosEstado/export/{format}', [AtivosGradPorEstadoController::class, 'export']);

#totais de docentes ativos por função
Route::get('/ativosDocentesPorFuncao', [AtivosDocentesPorFuncaoController::class, 'grafico']);
Route::get('/ativosDocentesPorFuncao/export/{format}', [AtivosDocentesPorFuncaoController::class, 'export']);

#totais de alunos ativos por cor/raça
Route::get('/ativosAlunosAutodeclarados', [AlunosAtivosAutodeclaradosController::class, 'grafico']);
Route::get('/ativosAlunosAutodeclarados/export/{format}', [AlunosAtivosAutodeclaradosController::class, 'export']);

#totais de alunos ativos da graduação por tipo de ingresso
Route::get('/ativosAlunosGradTipoIngresso', [AlunosAtivosGradTipoIngressoController::class, 'grafico']);
Route::get('/ativosAlunosGradTipoIngresso/export/{format}', [AlunosAtivosGradTipoIngressoController::class, 'export']);

#totais de alunos da graduação com benefício ativo em 2020
Route::get('/beneficiosAtivosGraduacao2020', [BeneficiosAtivosGraduacao2020Controller::class, 'grafico']);
Route::get('/beneficiosAtivosGraduacao2020/export/{format}', [BeneficiosAtivosGraduacao2020Controller::class, 'export']);

#totais de alunos da com benefício Bolsa Livro ativo em 2020
Route::get('/ativosBolsaLivro', [AtivosBolsaLivroController::class, 'grafico']);
Route::get('/ativosBolsaLivro/export/{format}', [AtivosBolsaLivroController::class, 'export']);

#totais de trancamentos por semestre e por curso
Route::get('/trancamentosCursoPorSemestre/{curso}', [TrancamentosCursoSemestralController::class, 'grafico']);
Route::get('/trancamentosCursoPorSemestre/export/{format}/{curso}', [TrancamentosCursoSemestralController::class, 'export']);

#totais de trancamentos por semestre do curso de Sociais
Route::get('/trancamentosSociaisPorSemestre', [TrancamentosSociaisSemestralController::class, 'grafico']);
Route::get('/trancamentosSociaisPorSemestre/export/{format}', [TrancamentosSociaisSemestralController::class, 'export']);

#totais de trancamentos por semestre do curso de Filosofia
Route::get('/trancamentosFilosofiaPorSemestre', [TrancamentosFilosofiaSemestralController::class, 'grafico']);
Route::get('/trancamentosFilosofiaPorSemestre/export/{format}', [TrancamentosFilosofiaSemestralController::class, 'export']);

#totais de trancamentos por semestre do curso de Geografia
Route::get('/trancamentosGeografiaPorSemestre', [TrancamentosGeografiaSemestralController::class, 'grafico']);
Route::get('/trancamentosGeografiaPorSemestre/export/{format}', [TrancamentosGeografiaSemestralController::class, 'export']);

#totais de trancamentos por semestre do curso de Historia
Route::get('/trancamentosHistoriaPorSemestre', [TrancamentosHistoriaSemestralController::class, 'grafico']);
Route::get('/trancamentosHistoriaPorSemestre/export/{format}', [TrancamentosHistoriaSemestralController::class, 'export']);

#totais de trancamentos por semestre do curso de Letras
Route::get('/trancamentosLetrasPorSemestre', [TrancamentosLetrasSemestralController::class, 'grafico']);
Route::get('/trancamentosLetrasPorSemestre/export/{format}', [TrancamentosLetrasSemestralController::class, 'export']);

#quantidade de alunos especiais em pós graduação por ano (2010-2010)
Route::get('/alunosEspeciaisPosGrAno', [AlunosEspeciaisPosGrAnoController::class, 'grafico']);
Route::get('/alunosEspeciaisPosGrAno/export/{format}', [AlunosEspeciaisPosGrAnoController::class, 'export']);

#quantidade de alunos especiais da graduação por ano (2010-2010)
Route::get('/alunosEspeciaisGrAno', [AlunosEspeciaisGrAnoController::class, 'grafico']);
Route::get('/alunosEspeciaisGrAno/export/{format}', [AlunosEspeciaisGrAnoController::class, 'export']);

#quantidade de alunos especiais da pós-graduação por departamento
Route::get('/alunosEspeciaisPosGrDpto', [AlunosEspeciaisPosGrDptoController::class, 'grafico']);
Route::get('/alunosEspeciaisPosGrDpto/export/{format}', [AlunosEspeciaisPosGrDptoController::class, 'export']);

#quantidade de ingressantes do gênero masculino no curso de Geografia 2010-2020
Route::get('/ingressantesGeoMasculino', [IngressantesMasculinoGeoController::class, 'grafico']);
Route::get('/ingressantesGeoMasculino/export/{format}', [IngressantesMasculinoGeoController::class, 'export']);

#quantidade de ingressantes do gênero feminino no curso de Geografia 2010-2020
Route::get('/ingressantesGeoFeminino', [IngressantesFemininoGeoController::class, 'grafico']);
Route::get('/ingressantesGeoFeminino/export/{format}', [IngressantesFemininoGeoController::class, 'export']);

#quantidade de alunos ativos da pós graduação, separados pelo nível de programa
Route::get('ativosPosNivelPgm', [AtivosPosNivelProgramaController::class, 'grafico']);
Route::get('ativosPosNivelPgm/export/{format}', [AtivosPosNivelProgramaController::class, 'export']);

#quantidade de orientadores credenciados, separados pela area de concentração do programa de pós graduação
Route::get('orientadoresPosGR', [OrientadoresPosGRContoller::class, 'grafico']);
Route::get('orientadoresPosGR/export/{format}', [OrientadoresPosGRContoller::class, 'export']);

#quantidade de coordenadores de curso de gradução, separados por gênero
Route::get('coordCursosGrad', [CoordCursosGradGeneroController::class, 'grafico']);
Route::get('coordCursosGrad/export/{format}', [CoordCursosGradGeneroController::class, 'export']);

#quantidade de ingressantes do gênero feminino no curso de Letras 2010-2020
Route::get('/ingressantesLetrasFeminino', [IngressantesFemininoLetrasController::class, 'grafico']);
Route::get('/ingressantesLetrasFeminino/export/{format}', [IngressantesFemininoLetrasController::class, 'export']);

#quantidade de ingressantes do gênero masculino no curso de Letras 2010-2020
Route::get('/ingressantesLetrasMasculino', [IngressantesMasculinoLetrasController::class, 'grafico']);
Route::get('/ingressantesLetrasMasculino/export/{format}', [IngressantesMasculinoLetrasController::class, 'export']);

#quantidade de ingressantes do gênero feminino no curso de Filosofia 2010-2020
Route::get('/ingressantesFilosofiaFeminino', [IngressantesFemininoFilosofiaController::class, 'grafico']);
Route::get('/ingressantesFilosofiaFeminino/export/{format}', [IngressantesFemininoFilosofiaController::class, 'export']);

#quantidade de ingressantes do gênero masculino no curso de Filosofia 2010-2020
Route::get('/ingressantesFilosofiaMasculino', [IngressantesMasculinoFilosofiaController::class, 'grafico']);
Route::get('/ingressantesFilosofiaMasculino/export/{format}', [IngressantesMasculinoFilosofiaController::class, 'export']);

#quantidade de ingressantes do gênero masculino no curso de História 2010-2020
Route::get('/ingressantesHistoriaMasculino', [IngressantesMasculinoHistoriaController::class, 'grafico']);
Route::get('/ingressantesHistoriaMasculino/export/{format}', [IngressantesMasculinoHistoriaController::class, 'export']);

#quantidade de ingressantes do gênero feminino no curso de História 2010-2020
Route::get('/ingressantesHistoriaFeminino', [IngressantesFemininoHistoriaController::class, 'grafico']);
Route::get('/ingressantesHistoriaFeminino/export/{format}', [IngressantesFemininoHistoriaController::class, 'export']);

#quantidade de ingressantes do gênero masculino no curso de Ciências Sociais 2010-2020
Route::get('/ingressantesSociaisMasculino', [IngressantesMasculinoSociaisController::class, 'grafico']);
Route::get('/ingressantesSociaisMasculino/export/{format}', [IngressantesMasculinoSociaisController::class, 'export']);

#quantidade de ingressantes do gênero feminino no curso de Ciências Socias 2010-2020
Route::get('/ingressantesSociaisFeminino', [IngressantesFemininoSociaisController::class, 'grafico']);
Route::get('/ingressantesSociaisFeminino/export/{format}', [IngressantesFemininoSociaisController::class, 'export']);

#quantidade de professores titulares ativos, por departamento
Route::get('/ativosProfTitularDpto', [AtivosProfTitularPorDptoController::class, 'grafico']);
Route::get('/ativosProfTitularDpto/export/{format}', [AtivosProfTitularPorDptoController::class, 'export']);

#quantidade de professores doutores ativos, por departamento
Route::get('/ativosProfDoutorDpto', [AtivosProfDoutorPorDptoController::class, 'grafico']);
Route::get('/ativosProfDoutorDpto/export/{format}', [AtivosProfDoutorPorDptoController::class, 'export']);

#quantidade de professores associados ativos, por departamento
Route::get('/ativosProfAssociadoDpto', [AtivosProfAssociadoPorDptoController::class, 'grafico']);
Route::get('/ativosProfAssociadoDpto/export/{format}', [AtivosProfAssociadoPorDptoController::class, 'export']);

#quantidade de Ex alunos de Graduação e Pós-Graduação
Route::get('/exAlunos', [ExAlunosController::class, 'grafico']);
Route::get('/exAlunos/export/{format}', [ExAlunosController::class, 'export']);

#export dados do programa
Route::get('/programas', [ProgramaController::class, 'index']);
Route::get('/programas/{codare}', [ProgramaController::class, 'show']);
Route::get('/programas/docente/{codpes}', [ProgramaController::class, 'docente']);

# Defesas
Route::get('/defesas', [DefesaController::class, 'index']);