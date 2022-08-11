<?php

namespace App\Http\Controllers\Api;

use Uspdev\Replicado\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Dados\AtivosPaisNascimentoDados;
use App\Http\Requests\AtivosPaisNascimentoRequest;

class AtivosPaisNascimentoController extends Controller
{

    /**
     * Alunos Ativos por Nacionalidade
     *
     * Retorna a quantidade de alunos de graduação, pós-graduação, cultura e extensão, pós doutorado ou docentes (segundo o parâmetro) por nacionalidade.
     * 
     * @group Dados por nacionalidade/localidade
     */
    public function index(AtivosPaisNascimentoRequest $request){
        return response()->json(
            AtivosPaisNascimentoDados::listar($request)['dados'],
            200, [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
    }

   
}
