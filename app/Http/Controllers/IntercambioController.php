<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Uspdev\Replicado\DB;
use Illuminate\Http\Request;
use Uspdev\Replicado\Graduacao;
use App\Utils\ReplicadoTemp;
use App\Utils\Util;

class IntercambioController extends Controller
{
    private $excel;

    public function listarIntercambios(Excel $excel, Request $request){
        $this->authorize('admins');
        $this->excel = $excel;

        $pessoa = $request->pessoa;
        $ano = $request->ano ?? Date('Y');
        $curso = $request->curso ?? 1;
        $setor = $request->setor ?? 1;

        if($pessoa == 'alunos_estrangeiros'){
            $result = ReplicadoTemp::listarAlunoEstrangeiro($ano);
        } else if($pessoa == 'alunos_intercambistas'){
            $result = ReplicadoTemp::listarAlunosIntercambistas($ano, $curso);
        } else if($pessoa == 'docentes_estrangeiros'){
            $result = ReplicadoTemp::listarDocentesEstrangeiros($ano, $setor);
        }

        $data = $result;

        $export = new DadosExport([$data], 
        [
            'Número USP',
            'Nome',
            'Data de início'
        ]);
        
        return $this->excel->download($export, "$pessoa".'_'.$ano.'intercambio.xlsx');
        
    }
}
