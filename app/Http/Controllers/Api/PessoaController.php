<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pessoa;
use App\Models\Lattes;
use App\Http\Requests\PessoaRequest;

class PessoaController extends Controller
{
    public function index(PessoaRequest $request){
        return response()->json(
            Pessoa::listar($request->validated())
        );
    }

    public function listarFalecidosPorPeriodo(PessoaRequest $request){
        $falecidos = Pessoa::whereBetween('dtaflc', [$request->dtaini, $request->dtafim])->get()->toArray();
        
        return response()->json(
            $falecidos            
        );
    }

    public function listarDocentes(){
        $docentes = Pessoa::where('tipo_vinculo', 'Docente')->get()->toArray();
        $resultado = [];

        foreach($docentes as $docente){
            $lattes = Lattes::where('codpes', $docente['codpes'])->first();
            
            if($lattes != NULL){
                $lattes = $lattes->toArray();
                if(isset($lattes['json']) && $lattes['json'] != NULL && $lattes['json'] != ''){
                    $json = json_decode($lattes['json']);
                    $docente['id_lattes'] = $json->id_lattes;
                }
            } 
            array_push($resultado, $docente);
        }
        
        return response()->json(
            $resultado
        );
    }


}
