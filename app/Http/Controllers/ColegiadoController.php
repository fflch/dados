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

    public function show($codclg){
        # TODO: validar $codclg
        
        $auxs = Pessoa::listarTitularesDoColegiado($codclg);
        $membros = [];
        foreach($auxs as $aux){
            $aux['suplente'] = ReplicadoTemp::obterSuplente($aux['titular'], $codclg); 
            $aux['vinculo_titular'] = ReplicadoTemp::obterVinculo((int)$aux['titular']) ;
            $aux['vinculo_suplente'] = $aux['suplente'] != 0 ? ReplicadoTemp::obterVinculo((int)$aux['suplente']) : '-';
            $aux['nome_titular'] = Pessoa::nomeCompleto((int)$aux['titular']) ;
            $aux['email_titular'] = Pessoa::retornarEmailUsp((int)$aux['titular']) ;
            $aux['nome_suplente'] = Pessoa::nomeCompleto((int)$aux['titular']) ;
            $aux['email_suplente'] = Pessoa::retornarEmailUsp((int)$aux['titular']) ;
            $membros[] = $aux;
        }
    
              
        
        return view('colegiados.show',[
            'codclg' => $codclg,
            'membros' => $membros
        ]);
    }
}
