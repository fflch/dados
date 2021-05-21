<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProgramaController;
use App\Http\Controllers\DefesaController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\PesquisaController;
use App\Http\Controllers\AtivosController;
use App\Http\Controllers\AtivosMicrosNotesController;
use App\Http\Controllers\AtivosPorGeneroController;
use App\Http\Controllers\AtivosPorGeneroGradController;
use App\Http\Controllers\AtivosPorGeneroPosController;
use App\Http\Controllers\AtivosPorGeneroDocentesController;
use App\Http\Controllers\AtivosPorGeneroEstagiariosController;
use App\Http\Controllers\AtivosPorGeneroFuncionariosController;
use App\Http\Controllers\AtivosPosDoutoradoPorCursoController;
use App\Http\Controllers\AlunosAtivosPorCursoController;
use App\Http\Controllers\AtivosPorDepartamentoController;
use App\Http\Controllers\AtivosPorProgramaPósController;
use App\Http\Controllers\AtivosPorGeneroCursoGradController;
use App\Http\Controllers\BeneficiadosController;
use App\Http\Controllers\BeneficiosConcedidosHistoricoController;
use App\Http\Controllers\Beneficios2019PorProgramaController;
use App\Http\Controllers\AtivosPorGeneroCEUController;
use App\Http\Controllers\ConcluintesPorAnoController;
use App\Http\Controllers\ConcluintesGradPorCursoController;
use App\Http\Controllers\AtivosPorGeneroPDController;
use App\Http\Controllers\ConveniosAtivosController;
use App\Http\Controllers\AtivosPorGeneroChefesAdministrativosController;
use App\Http\Controllers\AtivosPaisNascimentoController;
use App\Http\Controllers\AtivosGradPorEstadoController;
use App\Http\Controllers\AtivosDocentesPorFuncaoController;
use App\Http\Controllers\AlunosAtivosAutodeclaradosController;
use App\Http\Controllers\AlunosAtivosGradTipoIngressoController;
use App\Http\Controllers\BeneficiosAtivosGraduacao2020Controller;
use App\Http\Controllers\AtivosBolsaLivroController;
use App\Http\Controllers\TrancamentosCursoSemestralController;
use App\Http\Controllers\AlunosEspeciaisPorAnoController;
use App\Http\Controllers\IngressantesMasculinoGeoController;
use App\Http\Controllers\IngressantesFemininoGeoController;
use App\Http\Controllers\AtivosPosNivelProgramaController;
use App\Http\Controllers\CEUController;
use App\Http\Controllers\OrientadoresPosGRContoller;
use App\Http\Controllers\CoordCursosGradGeneroController;
use App\Http\Controllers\IngressantesFemininoLetrasController;
use App\Http\Controllers\IngressantesMasculinoLetrasController;
use App\Http\Controllers\IngressantesFemininoFilosofiaController;
use App\Http\Controllers\IngressantesMasculinoFilosofiaController;
use App\Http\Controllers\IngressantesMasculinoHistoriaController;
use App\Http\Controllers\IngressantesFemininoHistoriaController;
use App\Http\Controllers\IngressantesFemininoSociaisController;
use App\Http\Controllers\IngressantesMasculinoSociaisController;
use App\Http\Controllers\ExAlunosController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RestritoController;

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

# totais de alunos ativo por curso
Route::get('/alunosAtivosPorCurso/{tipvin}', [AlunosAtivosPorCursoController::class, 'grafico']);
Route::get('/alunosAtivosPorCurso/export/{format}/{tipvin}', [AlunosAtivosPorCursoController::class, 'export']);

# totais de funcionários, por departamento
Route::get('/ativosDepartamento/{tipvin}/{codfnc}', [AtivosPorDepartamentoController::class, 'grafico']);
Route::get('/ativosDepartamento/export/{format}/{tipvin}/{codfnc}', [AtivosPorDepartamentoController::class, 'export']);


# totais de alunos da pós graduação, por programa
Route::get('/ativosPorProgramaPos', [AtivosPorProgramaPósController::class, 'grafico']);
Route::get('/ativosPorProgramaPos/export/{format}', [AtivosPorProgramaPósController::class, 'export']);

# totais de alunos da graduação por gênero e por curso
Route::get('/ativosGenero/{tipvin}/{cod_curso}', [AtivosPorGeneroController::class, 'grafico']);
Route::get('/ativosGenero/export/{format}/{tipvin}/{cod_curso}', [AtivosPorGeneroController::class, 'export']);

# totais de alunos da graduação por gênero e por curso
Route::get('/ativosGradCurso/{cod_curso}', [AtivosPorGeneroCursoGradController::class, 'grafico']);
Route::get('/ativosGradCurso/export/{format}/{cod_curso}', [AtivosPorGeneroCursoGradController::class, 'export']);

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

# série histórica de concluintes da graduação e pós-graduação
Route::get('/concluintesPorAno/{vinculo}', [ConcluintesPorAnoController::class, 'grafico']);
Route::get('/concluintesPorAno/export/{format}/{vinculo}', [ConcluintesPorAnoController::class, 'export']);

# totais de alunos pós-doutorando por gênero
Route::get('/ativosPosDoutorado', [AtivosPorGeneroPDController::class, 'grafico']);
Route::get('/ativosPosDoutorado/export/{format}', [AtivosPorGeneroPDController::class, 'export']);

# concluintes da graduação em {ano}, por curso
Route::get('/concluintesGradPorCurso/{ano}', [ConcluintesGradPorCursoController::class, 'grafico']);
Route::get('/concluintesGradPorCurso/export/{format}/{ano}', [ConcluintesGradPorCursoController::class, 'export']);

# totais de convênios ativos
Route::get('/conveniosAtivos', [ConveniosAtivosController::class, 'grafico']);
Route::get('/conveniosAtivos/export/{format}', [ConveniosAtivosController::class, 'export']);

#totais de chefes administrativos ativos por gênero
Route::get('/ativosChefesAdministrativos', [AtivosPorGeneroChefesAdministrativosController::class, 'grafico']);
Route::get('/ativosChefesAdministrativos/export/{format}', [AtivosPorGeneroChefesAdministrativosController::class, 'export']);

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
Route::get('/beneficiosAtivosGraduacao2020', [BeneficiosAtivosGraduacao2020Controller::class, 'grafico']);
Route::get('/beneficiosAtivosGraduacao2020/export/{format}', [BeneficiosAtivosGraduacao2020Controller::class, 'export']);

#totais de alunos da com benefício Bolsa Livro ativo em 2020
Route::get('/ativosBolsaLivro', [AtivosBolsaLivroController::class, 'grafico']);
Route::get('/ativosBolsaLivro/export/{format}', [AtivosBolsaLivroController::class, 'export']);

#totais de trancamentos por semestre e por curso
Route::get('/trancamentosCursoPorSemestre/{curso}', [TrancamentosCursoSemestralController::class, 'grafico']);
Route::get('/trancamentosCursoPorSemestre/export/{format}/{curso}', [TrancamentosCursoSemestralController::class, 'export']);


#quantidade de alunos especiais da graduação e pós graduação por ano (2010-2010)
Route::get('/alunosEspeciaisPorAno/{vinculo}', [AlunosEspeciaisPorAnoController::class, 'grafico']);
Route::get('/alunosEspeciaisPorAno/export/{format}/{vinculo}', [AlunosEspeciaisPorAnoController::class, 'export']);

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

#quantidade de Ex alunos de Graduação e Pós-Graduação
Route::get('/exAlunos', [ExAlunosController::class, 'grafico']);
Route::get('/exAlunos/export/{format}', [ExAlunosController::class, 'export']);

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
Route::get('/iniciacao_cientifica', [PesquisaController::class, 'iniciacao_cientifica']);
Route::get('/pesquisadores_colaboradores', [PesquisaController::class, 'pesquisadores_colab']);
Route::get('/pesquisa_pos_doutorandos', [PesquisaController::class, 'pesquisa_pos_doutorandos']);
Route::get('/projetos_pesquisa', [PesquisaController::class, 'projetos_pesquisa']);

Route::get('/restrito', [RestritoController::class, 'restrito']);

Route::get('/restrito/curso_ceu', [CEUController::class, 'listarCurso']);