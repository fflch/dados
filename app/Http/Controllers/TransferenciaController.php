<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use App\Utils\ReplicadoTemp;
use Illuminate\Http\Request;
use Uspdev\Replicado\DB;
use Khill\Lavacharts\Lavacharts;

class TransferenciaController extends Controller
{
    private $excel;

    public function listarTransferencia(Excel $excel, Request $request){
        $this->authorize('admins');
        $this->excel = $excel;

        $curso = $request->curso ?? 1;
        $ano = $request->ano ?? Date('Y');
        $tipo = $request->tipo;
    
        $result = ReplicadoTemp::listarTransferencia($ano, $curso, $tipo);

        $export = new DadosExport([$result], 
        [
            'Número USP', 
            'Tipo Transferência', 
            'Data Ingresso', 
            'Curso'
        ]);

        return $this->excel->download($export, 'Ex_Alunos_Graduacao.xlsx');

    }

}