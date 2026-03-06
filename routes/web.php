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

Route::get('restrito/graduacao',function(){return view('restrito.graduacao');});
Route::get('restrito/posgraduacao',function(){return view('restrito.posgraduacao');});
Route::get('restrito/estagios',function(){return view('restrito.estagios');});
Route::get('restrito/extensao',function(){return view('restrito.extensao');});
Route::get('restrito/pesquisa',function(){return view('restrito.pesquisa');});
Route::get('restrito/internacional',function(){return view('restrito.internacional');});
Route::get('restrito/administrativo',function(){return view('restrito.administrativo');});
Route::get('restrito/docentes',function(){return view('restrito.docentes');});

use App\Http\Controllers\DisciplinaController;
Route::get('/turmas', [DisciplinaController::class, 'turmas']);
Route::get('/turmas/{prefix}', [DisciplinaController::class, 'prefix']);
Route::get('/turmas/{prefix}/concatenate', [DisciplinaController::class, 'concatenate']);