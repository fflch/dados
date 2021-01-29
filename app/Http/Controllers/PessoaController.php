<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pessoa;
use App\Http\Requests\PessoaRequest;

class PessoaController extends Controller
{
    public function index(PessoaRequest $request){
        return view('pessoas.index',[
            'pessoas' => Pessoa::listar($request->validated()),
        ]);
    }
}
