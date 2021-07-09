<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Uspdev\Replicado\DB;
use Illuminate\Http\Request;
use App\Utils\ReplicadoTemp;
class EvasaoController extends Controller
{
    private $excel;

    public function listarEvasao(Excel $excel, Request $request){
        $this->authorize('admins');
        $this->excel = $excel;

        $ano = $request->ano ?? Date('Y');
        $curso = $request->curso ?? 1;

        $result = ReplicadoTemp::listarEvasao($ano, $curso);
        $data = $result;

        $campos = [
            'Número USP',
            'Tipo ingresso',
            'Tipo desligamento',
            'Data ingresso',
            'Data evasao',
            'Curso'
        ];

        $export = new DadosExport([$data], $campos);
        
        return $this->excel->download($export, 'Evasao'.'_'.$ano.'.xlsx');
        
    }
}
