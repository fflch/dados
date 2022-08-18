<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Dados\AtivosPorGeneroDados;
use Uspdev\Replicado\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AtivosPorGeneroRequest;

class AtivosPorGeneroController extends Controller
{

    /**
     * Ativos Por Gênero
     *
     * Retorna a quantidade de alunos, docentes, funcionários e chefes (segundo o parâmetro) por gênero.
     *
     * @group Dados por gênero
     */
    public function index(AtivosPorGeneroRequest $request){
        return response()->json(
            AtivosPorGeneroDados::listar($request->validated())['dados'],
            200, [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
    }

}
