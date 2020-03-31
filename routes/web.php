<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'IndexController@index');

# totais com vínculos ativos
Route::get('/ativos', 'AtivosController@grafico');
Route::get('/ativosCsv', 'AtivosController@csv');


# totais com vínculos ativos da graduação, separados por curso
Route::get('/ativosPCGrad', 'AtivosPorCursoGradController@grafico');
Route::get('/ativosPCGradCsv', 'AtivosPorCursoGradController@csv');


# totais de microcomputadores e notebooks ativos
Route::get('/ativosMicrosNotes', 'AtivosMicrosNotesController@grafico');
Route::get('/ativosMicrosNotesCsv', 'AtivosMicrosNotesController@csv');


