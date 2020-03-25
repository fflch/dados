<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'IndexController@index');

# totais com vínculos ativos
Route::get('/ativos', 'AtivosController@grafico');
Route::get('/ativosCsv', 'AtivosController@csv');
