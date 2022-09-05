<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request; 
use Uspdev\Replicado\Posgraduacao;
use Uspdev\Replicado\Pessoa;
use App\Utils\ReplicadoTemp;
use App\Models\Lattes as LattesModel;
use App\Models\Programa;
use App\Utils\Util;
use App\Models\ComissaoPesquisa;
use App\Http\Controllers\Controller;
use App\Http\Requests\PesquisaRequest;


class PesquisaController extends Controller
{

    public function contarPesquisasAtivasPorTipo(PesquisaRequest $request){
        return response()->json(
            ComissaoPesquisa::contarPesquisasAtivasPorTipo($request),
            200, [], JSON_UNESCAPED_UNICODE
        );
    }

    public function listarIniciacaoCientifica(PesquisaRequest $request){
        return response()->json(
            ComissaoPesquisa::listarIniciacaoCientifica($request),
            200, [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
    }

    public function listarPesquisasPosDoutorandos(PesquisaRequest $request){
        return response()->json(
            ComissaoPesquisa::listarPesquisasPosDoutorandos($request),
            200, [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
    }

    public function listarProjetosPesquisa(Request $request){
        return response()->json(
            ComissaoPesquisa::listarProjetosPesquisa($request),
            200, [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
    }

    public function listarPesquisadoresColaboradores(Request $request){
        return response()->json(
            ComissaoPesquisa::listarPesquisadoresColaboradores($request),
            200, [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
    }
  
}
