<?php

use App\Http\Controllers\AtivosPorGeneroMestrandosController;
use Illuminate\Support\Facades\Route;

Route::get('/', 'IndexController@index');

# totais com vínculos ativos
Route::get('/ativos', 'AtivosController@grafico');
Route::get('/ativos/export/{format}', 'AtivosController@export');

# totais com vínculos ativos da graduação, separados por curso
Route::get('/ativosPCGrad', 'AtivosPorCursoGradController@grafico');
Route::get('/ativosPCGrad/export/{format}', 'AtivosPorCursoGradController@export');

# totais de microcomputadores e notebooks ativos
Route::get('/ativosMicrosNotes', 'AtivosMicrosNotesController@grafico');
Route::get('/ativosMicrosNotes/export/{format}', 'AtivosMicrosNotesController@export');

# totais de alunos da graduação, por gênero
Route::get('/ativosPGGrad', 'AtivosPorGeneroGradController@grafico');
Route::get('/ativosPGGrad/export/{format}', 'AtivosPorGeneroGradController@export');

# totais de alunos da pós graduação, por gênero
Route::get('/ativosPGPos', 'AtivosPorGeneroPosController@grafico');
Route::get('/ativosPGPos/export/{format}', 'AtivosPorGeneroPosController@export');

# totais de docentes, por gênero
Route::get('/ativosPGDocentes', 'AtivosPorGeneroDocentesController@grafico');
Route::get('/ativosPGDocentes/export/{format}', 'AtivosPorGeneroDocentesController@export');

# totais de estagiários, por gênero
Route::get('/ativosEstagiarios', 'AtivosPorGeneroEstagiariosController@grafico');
Route::get('/ativosEstagiarios/export/{format}', 'AtivosPorGeneroEstagiariosController@export');

# totais de funcionários, por gênero
Route::get('/ativosFuncionarios', 'AtivosPorGeneroFuncionariosController@grafico');
Route::get('/ativosFuncionarios/export/{format}', 'AtivosPorGeneroFuncionariosController@export');

# totais de alunos de pós-doutorado com programa ativo por curso
Route::get('/ativosPosDoutPorCurso', 'AtivosPosDoutoradoPorCursoController@grafico')->name('ativosposdoutoradocurso');
Route::get('/ativosPosDoutPorCurso/export/{format}', 'AtivosPosDoutoradoPorCursoController@export')->name('ativosposdoutoradocurso/export/{format}');

# totais de funcionários, por departamento
Route::get('/ativosFuncionariosDepartamento', 'AtivosPorDepartamentoFuncionariosController@grafico');
Route::get('/ativosFuncionariosDepartamento/export/{format}', 'AtivosPorDepartamentoFuncionariosController@export');

# totais de alunos da pós graduação, por programa
Route::get('/ativosPorProgramaPos', 'AtivosPorProgramaPósController@grafico');
Route::get('/ativosPorProgramaPos/export/{format}', 'AtivosPorProgramaPósController@export');

# totais de alunos da graduação em sociais por gênero
Route::get('/ativosGradSociais', 'AtivosPorGeneroCursoGradSociaisController@grafico');
Route::get('/ativosGradSociais/export/{format}', 'AtivosPorGeneroCursoGradSociaisController@export');

# totais de alunos da graduação em filosofia por gênero
Route::get('/ativosGradFilosofia', 'AtivosPorGeneroCursoGradFilosofiaController@grafico');
Route::get('/ativosGradFilosofia/export/{format}', 'AtivosPorGeneroCursoGradFilosofiaController@export');

# totais de alunos da graduação em geografia por gênero
Route::get('/ativosGradGeografia', 'AtivosPorGeneroCursoGradGeografiaController@grafico');
Route::get('/ativosGradGeografia/export/{format}', 'AtivosPorGeneroCursoGradGeografiaController@export');

# totais de alunos da graduação em história por gênero
Route::get('/ativosGradHistoria', 'AtivosPorGeneroCursoGradHistoriaController@grafico');
Route::get('/ativosGradHistoria/export/{format}', 'AtivosPorGeneroCursoGradHistoriaController@export');

# totais de alunos da graduação em Letras por gênero
Route::get('/ativosGradLetras', 'AtivosPorGeneroCursoGradLetrasController@grafico');
Route::get('/ativosGradLetras/export/{format}', 'AtivosPorGeneroCursoGradLetrasController@export');

# totais com algum benefício ativo
Route::get('/beneficiados', 'BeneficiadosController@grafico');
Route::get('/beneficiados/export/{format}', 'BeneficiadosController@export');

# série histórica de benefícios concedidos
Route::get('/ativosBeneficiosConHist', 'BeneficiosConcedidosHistoricoController@grafico');
Route::get('/ativosBeneficiosConHist/export/{format}', 'BeneficiosConcedidosHistoricoController@export');

# benefícios concedidos em 2019, por programa
Route::get('/Benef2019Prog', 'Beneficios2019PorProgramaController@grafico');
Route::get('/Benef2019Prog/export/{format}', 'Beneficios2019PorProgramaController@export');

# totais de alunos de cultura e extensão por gênero
Route::get('/ativosCulturaExtensao', 'AtivosPorGeneroCEUController@grafico');
Route::get('/ativosCulturaExtensao/export/{format}', 'AtivosPorGeneroCEUController@export');

# série histórica de concluintes da graduação
Route::get('/concluintesGradPorAno', 'ConcluintesGradPorAnoController@grafico');
Route::get('/concluintesGradPorAno/export/{format}', 'ConcluintesGradPorAnoController@export');

# totais de alunos pós-doutorando por gênero
Route::get('/ativosPosDoutorado', 'AtivosPorGeneroPDController@grafico');
Route::get('/ativosPosDoutorado/export/{format}', 'AtivosPorGeneroPDController@export');

# concluintes da graduação em 2014, por curso
Route::get('/concluintesGrad2014PorCurso', 'ConcluintesGradPorCurso2014Controller@grafico');
Route::get('/concluintesGrad2014PorCurso/export/{format}', 'ConcluintesGradPorCurso2014Controller@export');

# concluintes da graduação em 2015, por curso
Route::get('/concluintesGrad2015PorCurso', 'ConcluintesGradPorCurso2015Controller@grafico');
Route::get('/concluintesGrad2015PorCurso/export/{format}', 'ConcluintesGradPorCurso2015Controller@export');

# concluintes da graduação em 2016, por curso
Route::get('/concluintesGrad2016PorCurso', 'ConcluintesGradPorCurso2016Controller@grafico');
Route::get('/concluintesGrad2016PorCurso/export/{format}', 'ConcluintesGradPorCurso2016Controller@export');

# concluintes da graduação em 2017, por curso
Route::get('/concluintesGrad2017PorCurso', 'ConcluintesGradPorCurso2017Controller@grafico');
Route::get('/concluintesGrad2017PorCurso/export/{format}', 'ConcluintesGradPorCurso2017Controller@export');

# concluintes da graduação em 2018, por curso
Route::get('/concluintesGrad2018PorCurso', 'ConcluintesGradPorCurso2018Controller@grafico');
Route::get('/concluintesGrad2018PorCurso/export/{format}', 'ConcluintesGradPorCurso2018Controller@export');

# concluintes da graduação em 2019, por curso
Route::get('/concluintesGrad2019PorCurso', 'ConcluintesGradPorCurso2019Controller@grafico');
Route::get('/concluintesGrad2019PorCurso/export/{format}', 'ConcluintesGradPorCurso2019Controller@export');

# série histórica de concluintes da pós-graduação
Route::get('/concluintesPosPorAno', 'ConcluintesPosPorAnoController@grafico');
Route::get('/concluintesPosPorAno/export/{format}', 'ConcluintesPosPorAnoController@export');

# totais de convênios ativos
Route::get('/conveniosAtivos', 'ConveniosAtivosController@grafico');
Route::get('/conveniosAtivos/export/{format}', 'ConveniosAtivosController@export');

# totais com vínculos ativos da graduação, separados por cor/raça
Route::get('/autodeclaradosGradAtivos', 'AutodeclaradosGraducaoController@grafico');
Route::get('/autodeclaradosGradAtivos/export/{format}', 'AutodeclaradosGraducaoController@export');

# totais com vínculos ativos da pós-graduação, separados por cor/raça
Route::get('/autodeclaradosPosAtivos', 'AutodeclaradosPosController@grafico');
Route::get('/autodeclaradosPosAtivos/export/{format}', 'AutodeclaradosPosController@export');

# totais com vínculos ativos da cultura e extensão universitária, separados por cor/raça
Route::get('/autodeclaradosCeuAtivos', 'AutodeclaradosCeuController@grafico');
Route::get('/autodeclaradosCeuAtivos/export/{format}', 'AutodeclaradosCeuController@export');

#totais de alunos de mestrado ativos por gênero
Route::get('/ativosMestrandos', 'AtivosPorGeneroMestrandosController@grafico');
Route::get('/ativosMestrandos/export/{format}', 'AtivosPorGeneroMestrandosController@export');

#totais de chefes administrativos ativos por gênero
Route::get('/ativosChefesAdministrativos', 'AtivosPorGeneroChefesAdministrativosController@grafico');
Route::get('/ativosChefesAdministrativos/export/{format}', 'AtivosPorGeneroChefesAdministrativosController@export');

#totais de alunos ativos da graduação nascidos e não nascidos no br
Route::get('/ativosGradPaisNasc', 'AtivosGradPaisNascimentoController@grafico');
Route::get('/ativosGradPaisNasc/export/{format}', 'AtivosGradPaisNascimentoController@export');

#totais de alunos ativos da pós graduação nascidos e não nascidos no br
Route::get('/ativosPosPaisNasc', 'AtivosPosPaisNascimentoController@grafico');
Route::get('/ativosPosPaisNasc/export/{format}', 'AtivosPosPaisNascimentoController@export');

#totais de docentes ativos nascidos e não nascidos no br
Route::get('/ativosDocentesPaisNasc', 'AtivosDocentesPaisNascimentoController@grafico');
Route::get('/ativosDocentesPaisNasc/export/{format}', 'AtivosDocentesPaisNascimentoController@export');

#totais de alunos ativos de cultura e extensão universitária nascidos e não nascidos no br
Route::get('/ativosCeuPaisNasc', 'AtivosCeuPaisNascimentoController@grafico');
Route::get('/ativosCeuPaisNasc/export/{format}', 'AtivosCeuPaisNascimentoController@export');

#totais de alunos ativos pós doutorado nascidos e não nascidos no br
Route::get('/ativosPDPaisNasc', 'AtivosPDPaisNascimentoController@grafico');
Route::get('/ativosPDPaisNasc/export/{format}', 'AtivosPDPaisNascimentoController@export');

#totais de alunos da Graduação por estado (RG)
Route::get('/ativosAlunosEstado', 'AtivosGradPorEstadoController@grafico');
Route::get('/ativosAlunosEstado/export/{format}', 'AtivosGradPorEstadoController@export');

#totais de docentes ativos por função
Route::get('/ativosDocentesPorFuncao', 'AtivosDocentesPorFuncaoController@grafico');
Route::get('/ativosDocentesPorFuncao/export/{format}', 'AtivosDocentesPorFuncaoController@export');

#totais de alunos ativos por cor/raça
Route::get('/ativosAlunosAutodeclarados', 'AlunosAtivosAutodeclaradosController@grafico');
Route::get('/ativosAlunosAutodeclarados/export/{format}', 'AlunosAtivosAutodeclaradosController@export');

#totais de alunos ativos da graduação por tipo de ingresso
Route::get('/ativosAlunosGradTipoIngresso', 'AlunosAtivosGradTipoIngressoController@grafico');
Route::get('/ativosAlunosGradTipoIngresso/export/{format}', 'AlunosAtivosGradTipoIngressoController@export');