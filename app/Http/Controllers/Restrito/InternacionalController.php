<?php

namespace App\Http\Controllers\Restrito;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use App\Utils\Util;

class InternacionalController extends Controller
{
    public function index(){
        Gate::authorize('admin');
        return view('restrito.internacional');
    }
    
    public function listarIntercambistasRecebidos(Excel $excel, Request $request)
    {

        Gate::authorize('admin');
        
        $data = Util::query('listar_intercambistas_recebidos');

        $export = new DadosExport([$data],
        [
            'Nome',
            'NUSP',
            'Data de início',
            'Data fim'
        ]);

        return $excel->download($export,  'Intercambios.xlsx');
    }

}
