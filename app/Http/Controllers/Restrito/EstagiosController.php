<?php

namespace App\Http\Controllers\Restrito;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use App\Utils\Util;

class EstagiosController extends Controller
{
    public function index(){
        Gate::authorize('admin');
        return view('restrito.estagios');
    }
    function listarEstagiarios(Excel $excel, Request $request){
        Gate::authorize('admin');
        $ano = $request->ano ?? Date('Y');
        
        $data = Util::query('listar_estagiarios',['__ano__'=> $ano]);

        $export = new DadosExport([$data],
        [
            'Número USP',
            'Nome',
            'Setor',
            'Data de início',
            'Data fim'
        ]);

        return $excel->download($export, $ano . 'Estagiarios.xlsx');
    }
}
