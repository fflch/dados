<?php

namespace App\Http\Controllers\Restrito;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Illuminate\Http\Request;
use Uspdev\Replicado\DB;

class EstagiarioController extends Controller
{
    private $excel;

    public function index(Excel $excel, Request $request){
        Gate::authorize('admin');
        $this->excel = $excel;

        $ano = $request->ano ?? Date('Y');
        
        $query = file_get_contents(__DIR__ . '/../../../../Queries/listar_estagiarios.sql');
        $query_por_ano = str_replace('__ano__', $ano, $query);

        $result = DB::fetchAll($query_por_ano);
        $data = $result;

        $export = new DadosExport([$data],
        [
            'Número USP',
            'Nome',
            'Setor',
            'Data de início',
            'Data fim'
        ]);

        return $this->excel->download($export, $ano . 'Estagiarios.xlsx');
    }

}