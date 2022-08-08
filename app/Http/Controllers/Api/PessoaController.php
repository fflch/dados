<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pessoa;
use App\Http\Requests\DepartamentoRequest;

class PessoaController extends Controller
{  
    public function listarDocentes(){
        $docentes = Pessoa::listarDocentes();
        
        return response()->json(
            $docentes,
            200, [], JSON_UNESCAPED_UNICODE
        );
    }

    /**
     * Listar estagiários ativos
     * 
     * Retorna todos os estagiário ativos.
     * Faça a busca por departamento usando o parâmetro codset. Ex: api/estagiarios?codset=599
     * 
     * @group Quadro de servidores
     */
    public function listarEstagiarios(DepartamentoRequest $request){
        $estagiarios = Pessoa::listarEstagiarios($request);
        
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
