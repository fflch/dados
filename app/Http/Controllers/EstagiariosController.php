<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Illuminate\Http\Request;
use Uspdev\Replicado\DB;

class EstagiariosController extends Controller
{
    private $excel;

    public function listarEstagiarios(Excel $excel, Request $request){
        $this->authorize('admins');
        $this->excel = $excel;

        $ano = $request->ano ?? Date('Y');
        
        $query = file_get_contents(__DIR__ . '/../../../Queries/listar_estagiarios.sql');
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

        return $this->excel->download($export, 'Estagiarios.xlsx');
    }

}