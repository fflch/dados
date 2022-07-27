<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Dados\AlunosAtivosPorCursoDados;
use Uspdev\Replicado\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AlunosAtivosPorCursoRequest;

class AlunosAtivosPorCursoController extends Controller
{


    /**
     * Alunos Ativos Por Curso
     *
     * Retorna a quantidade de alunos de graduação ou pós doutorado (segundo o parâmetro) por curso.
     * 
     * @group Dados por curso
     */
    public function index(AlunosAtivosPorCursoRequest $request){
        return response()->json(
            AlunosAtivosPorCursoDados::listar($request),
            200, [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
    }

   
}
