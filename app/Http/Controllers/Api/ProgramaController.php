<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Programa;

class ProgramaController extends Controller
{
    public function index(){
        return response()->json(
            Programa::index()
        );
    }
}
