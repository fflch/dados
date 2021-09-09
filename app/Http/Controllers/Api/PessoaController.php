<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pessoa;

class PessoaController extends Controller
{  
    public function listarDocentes(){
        $docentes = Pessoa::listarDocentes();
        
        return response()->json(
            $docentes
        );
    }

    public function listarEstagiarios(){
        $estagiarios = Pessoa::listarEstagiarios();
        
        return response()->json(
            $estagiarios,
            200, [], JSON_UNESCAPED_UNICODE
        );
    }
    
    public function listarMonitores(){
        $monitores = Pessoa::listarMonitores();
        
        return response()->json(
            $monitores,
            200, [], JSON_UNESCAPED_SLASHES 
        );
    }
    
    public function listarServidores(){
        $servidores = Pessoa::listarServidores();
        
        return response()->json(
            $servidores
        );
    }
    
    public function listarChefesAdministrativos(){
        $chefes = Pessoa::listarChefesAdministrativos();
        
        return response()->json(
            $chefes,
            200, [], JSON_UNESCAPED_UNICODE
        );
    }

    public function listarChefesDepartamento(){
        $chefes_departamento = Pessoa::listarChefesDepartamento();
        
        return response()->json(
            $chefes_departamento,
            200, [], JSON_UNESCAPED_UNICODE
        );
    }


}
