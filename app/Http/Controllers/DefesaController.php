<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Uspdev\Replicado\Posgraduacao;

class DefesaController extends Controller
{
    public function index(Request $request){
        $anos = array_reverse(range(1950, Date('Y')));

        if($request->ano){
            $request->validate([
              'ano' => 'integer|gt:1950',
            ]);
            $ano = $request->ano;
        } else {
            $ano = Date('Y');
        }
        
        $intervalo = [
            'inicio' => $ano . '-01-01',
            'fim'    => $ano . '-12-31'
        ];
        $defesas = Posgraduacao::listarDefesas($intervalo);

        return view('defesas.index',[
            'anos'   => $anos,
            'defesas' => collect($defesas),
        ]);
    }
}
