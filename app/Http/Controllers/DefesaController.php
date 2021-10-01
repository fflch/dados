<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DefesaRequest;
use App\Models\Defesa;

class DefesaController extends Controller
{
    public function index(DefesaRequest $request){

        $retorno = Defesa::listar($request->validated());
        
        return view('defesas.index',[
            'mestrado' => $retorno['mestrado'],
            'doutorado' => $retorno['doutorado'],
            'doutorado_direto' => $retorno['doutorado_direto'],
            'defesas' => $retorno['defesas'],
        ]);
    }
}
