<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Uspdev\Replicado\Pessoa;
use App\Utils\ReplicadoTemp;

class ColegiadoController extends Controller
{
    public function index(){
        return view('colegiados.index',[
            'colegiados' => Pessoa::listarColegiados()
        ]);
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
            $aux['vinculo_titular'] = ReplicadoTemp::obterVinculo((int)$aux['titular']) ;
            $aux['vinculo_suplente'] = $aux['suplente'] != 0 ? ReplicadoTemp::obterVinculo((int)$aux['suplente']) : '-';
            $aux['email_titular'] = Pessoa::retornarEmailUsp((int)$aux['titular']) ;
            $aux['email_suplente'] = Pessoa::retornarEmailUsp((int)$aux['suplente']) ;
            $membros[] = $aux;
        }
              
        
        return view('colegiados.show',[
            'codclg' => $codclg,
            'membros' => $membros,
            'nome_colegiado' => $nomeClg
        ]);
    }
    
      
}
