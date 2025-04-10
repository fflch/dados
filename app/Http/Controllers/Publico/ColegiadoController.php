<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Uspdev\Replicado\Pessoa;

class ColegiadoController extends Controller
{
    public function index(){
        return view('colegiados.index',[
            'colegiados' => Pessoa::listarColegiados()
        ]);
    }
 
    public function show($codclg, $sglclg, Request $request){     
        
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
              
        
        return view('colegiados.show',[
            'sglclg' => $sglclg,
            'codclg' => $codclg,
            'membros' => $membros,
            'nome_colegiado' => $nomeClg,
            
        ]);
    }
}
