<?php

namespace App\Http\Controllers\Api;

use Uspdev\Replicado\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Dados\AlunosAtivosGradTipoIngressoDados;

class AlunosAtivosGradTipoIngressoController extends Controller
{

    /**
     * Alunos Ativos da Graduação por tipo de ingresso
     *
     * Retorna a quantidade de alunos de graduação agrupados por tipo de ingresso.
     * 
     * @group Dados por ingresso
     */
    public function index(){
        return response()->json(
            AlunosAtivosGradTipoIngressoDados::listar(),
            200, [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
    }
}

   