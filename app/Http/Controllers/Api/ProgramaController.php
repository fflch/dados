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

    public function show($codare, Request $request){
        
        $filtro = Programa::getFiltro($request);        
        $credenciados = Programa::show($codare, $filtro, $api = true);
        
        return response()->json(
            $credenciados
        );
    }
}
