<?php

use Illuminate\Support\Facades\Route;


# Index
use App\Http\Controllers\IndexController;
Route::get('/', [IndexController::class, 'index']);

# Restrito
use App\Http\Controllers\RestritoController;
Route::get('/restrito', [RestritoController::class, 'restrito']);

# Colegiados
use App\Http\Controllers\Publico\ColegiadoController;
Route::get('/colegiados', [ColegiadoController::class, 'index']);
Route::get('/colegiados/{codclg}/{sglclg}', [ColegiadoController::class, 'show']);

use App\Http\Controllers\Restrito;
Route::get('restrito/graduacao', [Restrito\GraduacaoController::class,'index']);
Route::get('restrito/posgraduacao', [Restrito\PosGraduacaoController::class,'index']);
Route::get('restrito/estagios', [Restrito\EstagiosController::class,'index']);
Route::get('restrito/extensao', [Restrito\ExtensaoController::class,'index']);
Route::get('restrito/pesquisa', [Restrito\PesquisaController::class,'index']);
Route::get('restrito/internacional', [Restrito\InternacionalController::class,'index']);
Route::get('restrito/administrativo', [Restrito\administrativoController::class,'index']);
Route::get('restrito/docentes',[Restrito\DocentesController::class,'index']);
Route::get('restrito/docentes/planilha',[Restrito\DocentesController::class,'planilhaDocentes']);

use App\Http\Controllers\DisciplinaController;
Route::get('/turmas', [DisciplinaController::class, 'turmas']);
Route::get('/turmas/{prefix}', [DisciplinaController::class, 'prefix']);
Route::get('/turmas/{prefix}/concatenate', [DisciplinaController::class, 'concatenate']);