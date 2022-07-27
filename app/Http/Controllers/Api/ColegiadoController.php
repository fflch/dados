<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Uspdev\Replicado\Pessoa;
use App\Utils\ReplicadoTemp;
use App\Http\Controllers\Controller;

class ColegiadoController extends Controller
{

    /**
     * Listar Colegiados
     *
     * Retorna uma lista com os colegiados da FFLCH.
     * 
     * @group Dados institucionais
     */
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
            $aux['vinculo_titular'] = ReplicadoTemp::obterVinculo((int)$aux['titular']) ;
            $aux['vinculo_suplente'] = $aux['suplente'] != 0 ? ReplicadoTemp::obterVinculo((int)$aux['suplente']) : '-';
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
