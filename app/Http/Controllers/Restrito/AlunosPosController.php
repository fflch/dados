<?php

namespace App\Http\Controllers\Restrito;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;

use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use App\Exports\DadosExportNoHeader;
use Uspdev\Replicado\DB;
use Uspdev\Replicado\Lattes;
use App\Utils\Util;
use Illuminate\Support\Facades\Log;

class AlunosPosController extends Controller
{
    var $colNames =[
        'NUSP',
        'email',
        'nome' 
    ];
    
    function listarPlanilha(Excel $excel, Request $request){
        Gate::authorize('admin');

        $areas = $request->area;
        $tipo = $request->tipo;
        $header = $request->header == "header";

        if ($tipo != "csv" && $tipo != "xlsx") {
            abort(400,'Tipo inválido');
        }
        //validar os codare
        if (is_null($areas)) {
            $areas = array_keys(Util::getAreas());
        }else {
            foreach ($areas as $area){
            if (is_null($area) || !(in_array($area,array_keys(Util::getAreas())))) {
                abort(400,'Area não existe');
            }    
        } 
        }  

        $areas = implode(", ",$areas);
        $data = Util::query('listar_posgr_por_ano_e_area',[
            '__area__' => $areas
        ]);

        if ($header) {
            $export = new DadosExport([$data], $this->colNames);
            }else{
            $export = new DadosExportNoHeader([$data]);
        }

        return $excel->download($export, $areas . ' - Alunos de Pós-Graduação.'.$tipo);
        
    }
    
}
