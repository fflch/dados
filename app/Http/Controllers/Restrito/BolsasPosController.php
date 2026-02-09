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
        'Nivel',
        'DataSelecao',
	    'DataInicioPrazo', 
	    'DataLimiteDeposito', 
	    'DataDefesa', 
        'Fomento',
        'Nome Fomento',
        'Inicio Fomento',
        'Fim Fomento'
    ];
    
    function listarPlanilha(Excel $excel, Request $request){
        Gate::authorize('admin');

        $areas = $request->area;
        $ano = $request->ano;

        //validar os codare
        if (is_null($areas) || is_null($ano)) {
            abort(400);
        }    
        foreach ($areas as $area){
            if (is_null($area) || !(in_array($area,array_keys(Util::getAreas())))) {
                abort(400,'Area não existe');
            }    
        }        

        $areas = implode(", ",$areas);
        //$data = Util::query('temp',[
        $data = Util::query('listar_posgr_por_ano_e_area',[
            '__area__' => $areas,
            '__ano__' => $ano
        ]);
        $export = new DadosExport([$data],
        $this->colNames);

        return $excel->download($export, $areas . ' - Bolsas.xlsx');
        
    }
    
}
