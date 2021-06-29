<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pessoa;
use App\Http\Requests\PessoaRequest;

class PessoaController extends Controller
{
    public function index(PessoaRequest $request){
        return response()->json(
            Pessoa::listar($request->validated())
        );
    }   

    public function listarDocentes(){
        $docentes = Pessoa::listarDocentes();
        
        return response()->json(
            $docentes
        );
    }

    public function listarEstagiarios(){
        $estagiarios = Pessoa::listarEstagiarios();
        
        return response()->json(
            $estagiarios
        );
    }
    
    public function listarMonitores(){
        $monitores = Pessoa::listarMonitores();
        
        return response()->json(
            $monitores
        );
    }


}
