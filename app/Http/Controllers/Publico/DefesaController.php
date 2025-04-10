<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\DefesaRequest;

use Uspdev\Replicado\Posgraduacao;
use Carbon\Carbon;
use Uspdev\Utils\Generic;
use Uspdev\Replicado\Lattes;

class DefesaController extends Controller
{
    public function index(DefesaRequest $request){

        $retorno = $this->listar($request->validated());
        
        return view('defesas.index',[
            'mestrado' => $retorno['mestrado'],
            'doutorado' => $retorno['doutorado'],
            'doutorado_direto' => $retorno['doutorado_direto'],
            'defesas' => $retorno['defesas'],
        ]);
    }

    private static function listar($filters, $isAPI = false){

        # 1. Filter by year
        if(!array_key_exists('ano',$filters)) $filters['ano'] = Date('Y');
        $intervalo = [
            'inicio' => $filters['ano'] . '-01-01',
            'fim'    => $filters['ano'] . '-12-31'
        ];
       
        
        # 2. Filter by codcur
        if(array_key_exists('codcur',$filters) && !empty($filters['codcur'])) {
            $defesas = Defesa::whereYear('data_defesa',$filters['ano'])->where('codcur',$filters['codcur'])->paginate(15);

            $mestrado = Defesa::whereYear('data_defesa',$filters['ano'])->where('codcur',$filters['codcur'])->where('nivpgm','ME')->count();
            $doutorado =  Defesa::whereYear('data_defesa',$filters['ano'])->where('codcur',$filters['codcur'])->where('nivpgm','DO')->count();
            $doutorado_direto =  Defesa::whereYear('data_defesa',$filters['ano'])->where('codcur',$filters['codcur'])->where('nivpgm','DD')->count();
        }else{
            $defesas = Defesa::whereYear('data_defesa',$filters['ano'])->paginate(15);

            $mestrado = Defesa::whereYear('data_defesa',$filters['ano'])->where('nivpgm','ME')->count();
            $doutorado =  Defesa::whereYear('data_defesa',$filters['ano'])->where('nivpgm','DO')->count();
            $doutorado_direto =  Defesa::whereYear('data_defesa',$filters['ano'])->where('nivpgm','DD')->count();
        }
    }
}
