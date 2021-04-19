<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pessoa;
use App\Http\Requests\PessoaRequest;

class PessoaController extends Controller
{
    public function index(PessoaRequest $request){
        return response()->json(
            Pessoa::listar($request->validated())
        );
    }

    public function retornarFalecidosPorPeriodo(PessoaRequest $request){
        return response()->json(
            \Uspdev\Replicado\Pessoa::retornarFalecidosPorPeriodo($request->dtaini, $request->dtafim)
        );
    }
}
