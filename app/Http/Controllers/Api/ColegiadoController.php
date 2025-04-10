<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Uspdev\Replicado\Pessoa;

class ColegiadoController extends Controller
{
    public function index(){
        return response()->json(
            Pessoa::listarColegiados(),
            200, [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
    }
 
    public function show($codclg, $sglclg,  Request $request){     
        
        $nomeClg = Pessoa::retornarNomeColegiado($codclg, $sglclg);

        if(!$nomeClg){
            $request->session()->flash('alert-danger', "Colegiado não encontrado. Busque pelos colegiados listados abaixo.");
            return redirect("/colegiados");
        
        }
        $auxs = Pessoa::listarTitularesSuplentesDoColegiado($codclg, $sglclg);

        $membros = [];
        foreach($auxs as $aux){
            $aux['email_titular'] = Pessoa::retornarEmailUsp((int)$aux['titular']) ;
            $aux['email_suplente'] = Pessoa::retornarEmailUsp((int)$aux['suplente']) ;
            $membros[] = $aux;
        }
        
        return response()->json(
            $membros,
            200, [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
    
    }  
}
