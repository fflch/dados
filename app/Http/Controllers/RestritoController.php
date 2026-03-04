<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Uspdev\Replicado\Posgraduacao;

class RestritoController extends Controller
{
    public function restrito()
    {
        Gate::authorize('admin');
        
        $aux_programas = Posgraduacao::programas(8);
        //eleiminar repetiçao de programas com varias areas;
        $programas = [];
        foreach ($aux_programas as $pr) {
            $programas[$pr["codcur"]]=$pr["nomcur"];
        };
        return view('restrito', [ 'programas' => $programas]);
    }
}
