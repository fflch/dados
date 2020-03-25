<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'IndexController@index');
Route::get('/exemplo', 'ReplicadoController@exemplo');
