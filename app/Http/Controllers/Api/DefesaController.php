<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\DefesaRequest;
use App\Models\Defesa;

class DefesaController extends Controller
{
    /**
     * Listar Defesas
     *
     * Retorna uma lista com as defesas de mestrado, doutorado e doutorado direto .
     * 
     * @group Dados de produção acadêmica
     */
    public function index(DefesaRequest $request){
        return response()->json(
            Defesa::listar($request->validated(), true),
            200, [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
    }
}
