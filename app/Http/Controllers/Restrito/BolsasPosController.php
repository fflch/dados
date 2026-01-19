<?php

namespace App\Http\Controllers\Restrito;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;

use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Uspdev\Replicado\DB;
use Uspdev\Replicado\Lattes;
use App\Utils\Util;
use Illuminate\Support\Facades\Log;

class BolsasPosController extends Controller
{
    var $colNames =[
        'Area', 
	    'NumeroUSPAluno', 
	    'NomeAluno', 
	    'EmailAluno', 
	    'DataInicioPrazo', 
	    'DataLimiteDeposito', 
	    'Nivel',
        'Fomento',
        'NFomento'
    ];
    
    function listarPlanilha(Excel $excel, Request $request){
        Log::alert($request->user()->codpes);
        Gate::authorize('admin');

        /* $sigla = $request->departamento;
        if (is_null($sigla) || !(in_array($sigla,array_keys(Util::departamentos)))) {
            abort(404,'Departamento não existe');
        }
        $dep = Util::departamentos[$sigla]; */
        $area = 8138;
        $ano = 2025;
        $data = Util::query('listar_posgr_por_ano_e_area',[
            '__area__' => $area,
            '__ano__' => $ano
        ]);
        $export = new DadosExport([$data],
        $this->colNames);

        return $excel->download($export, $area . ' - Bolsas.xlsx');
        
    }
    
}
