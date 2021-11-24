<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Uspdev\Replicado\Pessoa;

class ColegiadoController extends Controller
{
    public function index(){
        return view('colegiados.index',[
            'colegiados' => Pessoa::listarColegiados()
        ]);
    }

    public function show($codclg){
        # TODO: validar $codclg

        return view('colegiados.show',[
            'codclg' => $codclg,
            'membros' => Pessoa::listarTitularesSuplentesDoColegiado($codclg)
        ]);
    }
}
