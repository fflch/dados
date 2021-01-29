<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DefesaController;

Route::get('/defesas', [DefesaController::class, 'index']);
