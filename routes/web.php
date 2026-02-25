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

# Restrito: Estagiários
use App\Http\Controllers\Restrito\EstagiarioController;
Route::get('/restrito/estagiarios', [EstagiarioController::class, 'index']);


# Restrito...
use App\Http\Controllers\Restrito\IntercambistasController;
Route::get('/restrito/intercambitas/recebidos', [IntercambistasController::class, 'listarIntercambistasRecebidos']);

    
use App\Http\Controllers\DisciplinaController;
Route::get('/turmas', [DisciplinaController::class, 'turmas']);
Route::get('/turmas/{prefix}', [DisciplinaController::class, 'prefix']);
Route::get('/turmas/{prefix}/concatenate', [DisciplinaController::class, 'concatenate']);


use App\Http\Controllers\LattesController;
Route::prefix('lattes')->group(function () {
    Route::get('dashboard', [LattesController::class, 'dashboard'])->name('lattes.dashboard');
    //exports
    Route::get('docente/{codpes}/export', [LattesController::class, 'exportarDocente'])->name('lattes.exportar');
    Route::get('docente/{codpes}/export-detalhado', [LattesController::class, 'exportarDetalhado'])->name('lattes.exportar_detalhado');
    Route::get('api/metricas', [LattesController::class, 'apiMetricas'])->name('lattes.api.metricas');
});

// Em routes/web.php
Route::get('/lattes/json/{codpes}', [LattesController::class, 'exportarJson'])->name('lattes.exportar_json');
