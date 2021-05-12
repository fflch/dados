<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pessoa;
use App\Models\Lattes;
use Uspdev\Replicado\Lattes as LattesReplicado;
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


}
