<?php

namespace App\Http\Controllers\Api;

use Uspdev\Replicado\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Dados\AlunosAtivosEstadoDados;

class AlunosAtivosEstadoController extends Controller
{

    /**
     * Alunos Ativos por estado brasileiro
     *
     * Retorna a quantidade de alunos de graduação, pós-graduação, cultura e extensão, pós doutorado ou docentes (segundo o parâmetro) agrupados por estado.
     * 
     * @group Dados por nacionalidade/localidade
     */
    public function index(){
        return response()->json(
            AlunosAtivosEstadoDados::listar(),
            200, [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
    }

   
}