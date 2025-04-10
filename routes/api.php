<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

# Colegiados
use App\Http\Controllers\Api\ColegiadoController;
Route::get('/colegiados', [ColegiadoController::class, 'index']);
Route::get('/colegiados/{codclg}/{sglclg}', [ColegiadoController::class, 'show']);
