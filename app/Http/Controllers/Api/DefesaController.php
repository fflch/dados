<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\DefesaRequest;
use App\Models\Defesa;

class DefesaController extends Controller
{
    public function index(DefesaRequest $request){
        return response()->json(
            Defesa::listar($request->validated()),
            200, [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
    }
}
