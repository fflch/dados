<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use Illuminate\Http\Request;
use App\Exports\DadosExport;
use Uspdev\Replicado\DB;
use Uspdev\Replicado\CEU;
use App\Utils\Util;

class CEUController extends Controller

{
    private $excel;

    public function listarCurso(Excel $excel, Request $request)
    {
        $this->authorize('admins');
        $this->excel = $excel;

        $departamento = $request->departamento ?? 1;
        
        $ano_inicio = $request->ano_inicio ?? Date('Y');
        $ano_fim = $request->ano_fim ?? Date('Y');
               
        //listar todos os departamentos
        if($departamento == 1){
            $dptos = [];
            foreach(Util::departamentos as $dpto){
                array_push($dptos, $dpto[0]);
            }
            $departamento = $dptos;
        }else{
            $departamento = [(int)$departamento];
        }
        
        $result = CEU::listarCursos($ano_inicio, $ano_fim, $departamento);

        $data = $result;

        $export = new DadosExport([$data], 
        [
            'Código curso CEU', 
            'Código departamento', 
            'Departamento', 
            'Nome curso', 
            'Vagas', 
            'Matriculados',
	        'Descrição', 
            'Objetivo', 
            'Justificativa', 
            'Formato', 
            'Data início', 
            'Data final', 
	        'Motivo curso a distância', 
            'Carga horária miníma', 
            'Carga horária total',
            'Ministrantes' 
        ]);

        return $this->excel->download($export, 'curso_CEU.xlsx');
    }

}
