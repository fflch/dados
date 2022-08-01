<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Dados\AlunosAtivosAutodeclaradosDados;
use Uspdev\Replicado\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AlunosAtivosAutodeclaradosRequest;

class AlunosAtivosAutodeclaradosController extends Controller
{


    /**
     * Totais de alunos autodeclarados por raça/cor
     *
     * Retorna a quantidade de alunos de graduação, pós-graduação, cultura e extensão ou pós doutorado (segundo o parâmetro) por raça/cor.
     * 
     * @group Dados por cor/raça
     */
    public function index(AlunosAtivosAutodeclaradosRequest $request){
        return response()->json(
            AlunosAtivosAutodeclaradosDados::listar($request)['dados'],
            200, [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
    }


}