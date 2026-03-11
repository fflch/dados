<?php

namespace App\Http\Controllers\Restrito;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GraduacaoController extends Controller
{
    public function index(){
        return view('restrito.graduacao');
    }
}
