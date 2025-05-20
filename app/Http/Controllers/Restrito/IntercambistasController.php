<?php

namespace App\Http\Controllers\Restrito;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Illuminate\Http\Request;
use Uspdev\Replicado\DB;

class IntercambistasController extends Controller
{


    private $excel;
    public function listarIntercambistasRecebidos(Excel $excel, Request $request)
    {

        Gate::authorize('admin');
        $this->excel = $excel;
        
        $query = file_get_contents(__DIR__ . '/../../../../Queries/listar_intercambistas_recebidos.sql');

        $result = DB::fetchAll($query);
        $data = $result;

        $export = new DadosExport([$data],
        [
            'Nome',
            'NUSP',
            'Data de início',
            'Data fim'
        ]);

        return $this->excel->download($export,  'Intercambios.xlsx');
    }
}
