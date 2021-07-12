<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgramaController;
use App\Http\Controllers\DefesaController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\PesquisaController;
use App\Http\Controllers\AtivosController;
use App\Http\Controllers\AtivosMicrosNotesController;
use App\Http\Controllers\AtivosPorGeneroController;
use App\Http\Controllers\AlunosAtivosPorCursoController;
use App\Http\Controllers\AtivosPorDepartamentoController;
use App\Http\Controllers\AtivosPorProgramaPosController;
use App\Http\Controllers\BeneficiadosController;
use App\Http\Controllers\BeneficiosConcedidosHistoricoController;
use App\Http\Controllers\BeneficiosConcedidosController;
use App\Http\Controllers\ConcluintesPorAnoController;
use App\Http\Controllers\ConcluintesGradPorCursoController;
use App\Http\Controllers\ConveniosAtivosController;
use App\Http\Controllers\AtivosPaisNascimentoController;
use App\Http\Controllers\AtivosGradPorEstadoController;
use App\Http\Controllers\AtivosDocentesPorFuncaoController;
use App\Http\Controllers\AlunosAtivosAutodeclaradosController;
use App\Http\Controllers\AlunosAtivosGradTipoIngressoController;
use App\Http\Controllers\BeneficiosAtivosGraduacaoPorAnoController;
use App\Http\Controllers\TrancamentosCursoSemestralController;
use App\Http\Controllers\AlunosEspeciaisPorAnoController;
use App\Http\Controllers\AtivosPosNivelProgramaController;
use App\Http\Controllers\CEUController;
use App\Http\Controllers\OrientadoresPosGRContoller;
use App\Http\Controllers\IngressantesGeneroCursoController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\IniciacaoCientificaController;
use App\Http\Controllers\ExAlunosController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RestritoController;
use App\Http\Controllers\AlunosEspeciaisPosGrDptoController;
use App\Http\Controllers\IntercambioController;

Route::get('/', [IndexController::class, 'index']);
Route::get('/sobre', [IndexController::class, 'sobre']);

Route::get('login', [LoginController::class, 'redirectToProvider']);
Route::get('callback', [LoginController::class, 'handleProviderCallback']);
Route::post('logout', [LoginController::class, 'logout']);

# totais com vínculos ativos
Route::get('/ativos', [AtivosController::class, 'grafico']);
Route::get('/ativos/export/{format}', [AtivosController::class, 'export']);

# totais de microcomputadores e notebooks ativos
Route::get('/ativosMicrosNotes', [AtivosMicrosNotesController::class, 'grafico']);
Route::get('/ativosMicrosNotes/export/{format}', [AtivosMicrosNotesController::class, 'export']);

# totais de alunos ativo por curso
Route::get('/alunosAtivosPorCurso/{tipvin}', [AlunosAtivosPorCursoController::class, 'grafico']);
Route::get('/alunosAtivosPorCurso/export/{format}/{tipvin}', [AlunosAtivosPorCursoController::class, 'export']);

# totais de funcionários, por departamento
Route::get('/ativosDepartamento/{tipvin}/{codfnc}', [AtivosPorDepartamentoController::class, 'grafico']);
Route::get('/ativosDepartamento/export/{format}/{tipvin}/{codfnc}', [AtivosPorDepartamentoController::class, 'export']);

# totais de alunos da pós graduação, por programa
Route::get('/ativosPorProgramaPos', [AtivosPorProgramaPosController::class, 'grafico']);
Route::get('/ativosPorProgramaPos/export/{format}', [AtivosPorProgramaPosController::class, 'export']);

# totais de alunos da graduação por gênero e por curso
Route::get('/ativosGenero/{tipvin}/{cod_curso}', [AtivosPorGeneroController::class, 'grafico']);
Route::get('/ativosGenero/export/{format}/{tipvin}/{cod_curso}', [AtivosPorGeneroController::class, 'export']);

# totais com algum benefício ativo
Route::get('/beneficiados', [BeneficiadosController::class, 'grafico']);
Route::get('/beneficiados/export/{format}', [BeneficiadosController::class, 'export']);

# série histórica de benefícios concedidos
Route::get('/ativosBeneficiosConHist', [BeneficiosConcedidosHistoricoController::class, 'grafico']);
Route::get('/ativosBeneficiosConHist/export/{format}', [BeneficiosConcedidosHistoricoController::class, 'export']);

# benefícios concedidos em 2019, por programa
Route::get('/beneficiosConcedidos/{ano}', [BeneficiosConcedidosController::class, 'grafico']);
Route::get('/beneficiosConcedidos/export/{format}/{ano}', [BeneficiosConcedidosController::class, 'export']);

# série histórica de concluintes da graduação e pós-graduação
Route::get('/concluintesPorAno', [ConcluintesPorAnoController::class, 'grafico']);
Route::get('/concluintesPorAno/export/{format}', [ConcluintesPorAnoController::class, 'export']);

# concluintes da graduação em {ano}, por curso
Route::get('/concluintesGradPorCurso/{ano}', [ConcluintesGradPorCursoController::class, 'grafico']);
Route::get('/concluintesGradPorCurso/export/{format}/{ano}', [ConcluintesGradPorCursoController::class, 'export']);

# totais de convênios ativos
Route::get('/conveniosAtivos', [ConveniosAtivosController::class, 'grafico']);
Route::get('/conveniosAtivos/export/{format}', [ConveniosAtivosController::class, 'export']);

#totais de alunos e docentes ativos nascidos e não nascidos no br
Route::get('/ativosPaisNascimento/{tipo_vinculo}', [AtivosPaisNascimentoController::class, 'grafico']);
Route::get('/ativosPaisNascimento/export/{format}/{tipo_vinculo}', [AtivosPaisNascimentoController::class, 'export']);

#totais de alunos da Graduação por estado (RG)
Route::get('/ativosAlunosEstado', [AtivosGradPorEstadoController::class, 'grafico']);
Route::get('/ativosAlunosEstado/export/{format}', [AtivosGradPorEstadoController::class, 'export']);

#totais de docentes ativos por função
Route::get('/ativosDocentesPorFuncao', [AtivosDocentesPorFuncaoController::class, 'grafico']);
Route::get('/ativosDocentesPorFuncao/export/{format}', [AtivosDocentesPorFuncaoController::class, 'export']);

#totais de alunos ativos por cor/raça
Route::get('/ativosAlunosAutodeclarados/{vinculo}', [AlunosAtivosAutodeclaradosController::class, 'grafico']);
Route::get('/ativosAlunosAutodeclarados/export/{format}/{vinculo}', [AlunosAtivosAutodeclaradosController::class, 'export']);

#totais de alunos ativos da graduação por tipo de ingresso
Route::get('/ativosAlunosGradTipoIngresso', [AlunosAtivosGradTipoIngressoController::class, 'grafico']);
Route::get('/ativosAlunosGradTipoIngresso/export/{format}', [AlunosAtivosGradTipoIngressoController::class, 'export']);

#totais de alunos da graduação com benefício ativo em 2020
Route::get('/beneficiosAtivosGraduacaoPorAno/{ano}', [BeneficiosAtivosGraduacaoPorAnoController::class, 'grafico']);
Route::get('/beneficiosAtivosGraduacaoPorAno/export/{format}/{ano}', [BeneficiosAtivosGraduacaoPorAnoController::class, 'export']);

#totais de trancamentos por semestre e por curso
Route::get('/trancamentosCursoPorSemestre/{curso}', [TrancamentosCursoSemestralController::class, 'grafico']);
Route::get('/trancamentosCursoPorSemestre/export/{format}/{curso}', [TrancamentosCursoSemestralController::class, 'export']);


#quantidade de alunos especiais da graduação e pós graduação por ano (2010-2010)
Route::get('/alunosEspeciaisPorAno', [AlunosEspeciaisPorAnoController::class, 'grafico']);
Route::get('/alunosEspeciaisPorAno/export/{format}', [AlunosEspeciaisPorAnoController::class, 'export']);

#quantidade de ingressantes do gênero masculino no curso de Geografia 2010-2020
Route::get('/IngressantesGeneroCurso', [IngressantesGeneroCursoController::class, 'grafico']);
Route::get('/IngressantesGeneroCurso/export/{format}', [IngressantesGeneroCursoController::class, 'export']);

#quantidade de alunos ativos da pós graduação, separados pelo nível de programa
Route::get('ativosPosNivelPgm', [AtivosPosNivelProgramaController::class, 'grafico']);
Route::get('ativosPosNivelPgm/export/{format}', [AtivosPosNivelProgramaController::class, 'export']);

#quantidade de orientadores credenciados, separados pela area de concentração do programa de pós graduação
Route::get('orientadoresPosGR', [OrientadoresPosGRContoller::class, 'grafico']);
Route::get('orientadoresPosGR/export/{format}', [OrientadoresPosGRContoller::class, 'export']);

#quantidade de Ex alunos de Graduação e Pós-Graduação
Route::get('/exAlunos', [ExAlunosController::class, 'grafico']);
Route::get('/exAlunos/export/{format}', [ExAlunosController::class, 'export']);

#quantidade de alunos especiais de Pós-Graduação por departamento
Route::get('/alunosEspeciaisPosGrDpto', [AlunosEspeciaisPosGrDptoController::class, 'grafico']);
Route::get('/alunosEspeciaisPosGrDpto/export/{format}', [AlunosEspeciaisPosGrDptoController::class, 'export']);
# Programas
Route::get('/programas', [ProgramaController::class, 'index']);
Route::get('/programas/docentes/{codare}', [ProgramaController::class, 'listarDocentes']);
Route::get('/programas/docente/{id_lattes}', [ProgramaController::class, 'docente']);
Route::get('/programas/discentes/{codare}', [ProgramaController::class, 'listarDiscentes']);
Route::get('/programas/discente/{id_lattes}', [ProgramaController::class, 'discente']);
Route::get('/programas/egresso/{id_lattes}', [ProgramaController::class, 'egresso']);
Route::get('/programas/egressos/{codare}', [ProgramaController::class, 'listarEgressos']);

# Defesas
Route::get('/defesas', [DefesaController::class, 'index']);

# Pessoas
Route::get('/pessoas', [PessoaController::class, 'index']);

# Pesquisa
Route::get('/pesquisa', [PesquisaController::class, 'index']);
Route::get('/iniciacao_cientifica', [IniciacaoCientificaController::class, 'iniciacao_cientifica']);
Route::get('/iniciacao_cientifica/export/{format}', [IniciacaoCientificaController::class, 'export']);

Route::get('/pesquisadores_colaboradores', [PesquisaController::class, 'pesquisadores_colab']);
Route::get('/pesquisa_pos_doutorandos', [PesquisaController::class, 'pesquisa_pos_doutorandos']);
Route::get('/projetos_pesquisa', [PesquisaController::class, 'projetos_pesquisa']);

Route::get('/restrito', [RestritoController::class, 'restrito']);

Route::get('/restrito/curso_ceu', [CEUController::class, 'listarCurso']);

Route::get('/restrito/ex_alunos', [ExAlunosController::class, 'listarExAlunos']);

Route::get('/restrito/intercambio', [IntercambioController::class, 'listarIntercambios']);
# Logs  
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->middleware('can:admins');
