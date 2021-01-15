<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Uspdev\Replicado\Posgraduacao;
use App\Utils\ReplicadoTemp;

class ProgramaController extends Controller
{
    public function index(){
        $programas = Posgraduacao::programas(8);
        return view('programas.index',[
            'programas' => $programas,
        ]);
    }

    public function show($codare) {
        # Mostrar nome do programa
        # Deixar em ordem alfabética
        $credenciados = ReplicadoTemp::credenciados($codare);

        return view('programas.show',[
            'credenciados' => $credenciados,
        ]);
    }
}
