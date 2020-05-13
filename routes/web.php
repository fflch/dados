<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'IndexController@index');

# totais com vínculos ativos
Route::get('/ativos', 'AtivosController@grafico');
Route::get('/ativosCsv', 'AtivosController@csv');

# totais com vínculos ativos da graduação, separados por curso
Route::get('/ativosPCGrad', 'AtivosPorCursoGradController@grafico');
Route::get('/ativosPCGrad/export/{format}', 'AtivosPorCursoGradController@export');

# totais de microcomputadores e notebooks ativos
Route::get('/ativosMicrosNotes', 'AtivosMicrosNotesController@grafico');
Route::get('/ativosMicrosNotesCsv', 'AtivosMicrosNotesController@csv');

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
Route::get('/ativosPosDoutPorCursoCsv', 'AtivosPosDoutoradoPorCursoController@csv')->name('ativosposdoutoradocursocsv');

# totais de funcionários, por departamento
Route::get('/ativosFuncionariosDepartamento', 'AtivosPorDepartamentoFuncionariosController@grafico');
Route::get('/ativosFuncionariosDepartamento/export/{format}', 'AtivosPorDepartamentoFuncionariosController@export');

# totais de alunos da pós graduação, por programa
Route::get('/ativosPorProgramaPos', 'AtivosPorProgramaPósController@grafico');
Route::get('/ativosPorProgramaPosCsv', 'AtivosPorProgramaPósController@csv');
# totais de alunos da graduação em sociais por gênero
Route::get('/ativosGradSociais', 'AtivosPorGeneroCursoGradSociaisController@grafico');
Route::get('/ativosGradSociaisCsv', 'AtivosPorGeneroCursoGradSociaisController@csv');

# totais de alunos da graduação em filosofia por gênero
Route::get('/ativosGradFilosofia', 'AtivosPorGeneroCursoGradFilosofiaController@grafico');
Route::get('/ativosGradFilosofiaCsv', 'AtivosPorGeneroCursoGradFilosofiaController@csv');

# totais de alunos da graduação em geografia por gênero
Route::get('/ativosGradGeografia', 'AtivosPorGeneroCursoGradGeografiaController@grafico');
Route::get('/ativosGradGeografiaCsv', 'AtivosPorGeneroCursoGradGeografiaController@csv');

# totais de alunos da graduação em história por gênero
Route::get('/ativosGradHistoria', 'AtivosPorGeneroCursoGradHistoriaController@grafico');
Route::get('/ativosGradHistoriaCsv', 'AtivosPorGeneroCursoGradHistoriaController@csv');

# totais de alunos da graduação em Letras por gênero
Route::get('/ativosGradLetras', 'AtivosPorGeneroCursoGradLetrasController@grafico');
Route::get('/ativosGradLetrasCsv', 'AtivosPorGeneroCursoGradLetrasController@csv');

# totais com algum benefício ativo
Route::get('/ativosBeneficios', 'AtivosBeneficiosController@grafico');
Route::get('/ativosBeneficiosCsv', 'AtivosBeneficiosController@csv');

# série histórica de benefícios concedidos
Route::get('/ativosBeneficiosConHist', 'BeneficiosConcedidosHistoricoController@grafico');
Route::get('/ativosBeneficiosConHistCsv', 'BeneficiosConcedidosHistoricoController@csv');

# benefícios concedidos em 2019, por programa
Route::get('/Benef2019Prog', 'Beneficios2019PorProgramaController@grafico');
Route::get('/Benef2019ProgCsv', 'Beneficios2019PorProgramaController@csv');

# totais de alunos de cultura e extensão por gênero
Route::get('/ativosCulturaExtensao', 'AtivosPorGeneroCEUController@grafico');
Route::get('/ativosCulturaExtensao/export/{format}', 'AtivosPorGeneroCEUController@export');

# série histórica de concluintes da graduação
Route::get('/concluintesGradPorAno', 'ConcluintesGradPorAnoController@grafico');
Route::get('/concluintesGradPorAnoCsv', 'ConcluintesGradPorAnoController@csv');

# totais de alunos pós-doutorando por gênero
Route::get('/ativosPosDoutorado', 'AtivosPorGeneroPDController@grafico');
Route::get('/ativosPosDoutoradoCsv', 'AtivosPorGeneroPDController@csv');

# concluintes da graduação em 2014, por curso
Route::get('/concluintesGrad2014PorCurso', 'ConcluintesGradPorCurso2014Controller@grafico');
Route::get('/concluintesGrad2014PorCursoCsv', 'ConcluintesGradPorCurso2014Controller@csv');

# concluintes da graduação em 2015, por curso
Route::get('/concluintesGrad2015PorCurso', 'ConcluintesGradPorCurso2015Controller@grafico');
Route::get('/concluintesGrad2015PorCursoCsv', 'ConcluintesGradPorCurso2015Controller@csv');

# concluintes da graduação em 2016, por curso
Route::get('/concluintesGrad2016PorCurso', 'ConcluintesGradPorCurso2016Controller@grafico');
Route::get('/concluintesGrad2016PorCursoCsv', 'ConcluintesGradPorCurso2016Controller@csv');

# concluintes da graduação em 2017, por curso
Route::get('/concluintesGrad2017PorCurso', 'ConcluintesGradPorCurso2017Controller@grafico');
Route::get('/concluintesGrad2017PorCursoCsv', 'ConcluintesGradPorCurso2017Controller@csv');

# concluintes da graduação em 2018, por curso
Route::get('/concluintesGrad2018PorCurso', 'ConcluintesGradPorCurso2018Controller@grafico');
Route::get('/concluintesGrad2018PorCursoCsv', 'ConcluintesGradPorCurso2018Controller@csv');

# concluintes da graduação em 2019, por curso
Route::get('/concluintesGrad2019PorCurso', 'ConcluintesGradPorCurso2019Controller@grafico');
Route::get('/concluintesGrad2019PorCursoCsv', 'ConcluintesGradPorCurso2019Controller@csv');

# série histórica de concluintes da pós-graduação
Route::get('/concluintesPosPorAno', 'ConcluintesPosPorAnoController@grafico');
Route::get('/concluintesPosPorAnoCsv', 'ConcluintesPosPorAnoController@csv');

# totais de convênios ativos
Route::get('/conveniosAtivos', 'ConveniosAtivosController@grafico');
Route::get('/conveniosAtivos/export/{format}', 'ConveniosAtivosController@export');

# totais com vínculos ativos da graduação, separados por cor/raça
Route::get('/autodeclaradosGradAtivos', 'AutodeclaradosGraducaoController@grafico');
Route::get('/autodeclaradosGradAtivosCsv', 'AutodeclaradosGraducaoController@csv');

# totais com vínculos ativos da pós-graduação, separados por cor/raça
Route::get('/autodeclaradosPosAtivos', 'AutodeclaradosPosController@grafico');
Route::get('/autodeclaradosPosAtivosCsv', 'AutodeclaradosPosController@csv');

# totais com vínculos ativos da cultura e extensão universitária, separados por cor/raça
Route::get('/autodeclaradosCeuAtivos', 'AutodeclaradosCeuController@grafico');
Route::get('/autodeclaradosCeuAtivosCsv', 'AutodeclaradosCeuController@csv');