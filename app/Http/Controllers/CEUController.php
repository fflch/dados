<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use Illuminate\Http\Request;
use App\Exports\DadosExport;
use Uspdev\Replicado\DB;
use App\Utils\Util;

class CEUController extends Controller

{
    private $excel;

    public function listarCurso(Excel $excel, Request $request)
    {
        $this->authorize('admins');
        $this->excel = $excel;

        $query = file_get_contents(__DIR__ . '/../../../Queries/listar_curso_ceu.sql');

        $departamento = $request->departamento ?? 1;
        
        $ano_inicio = $request->ano_inicio ?? Date('Y');
        $ano_fim = $request->ano_fim ?? Date('Y');
               
        //listar todos os departamentos
        if($departamento == 1){
            $dptos = [];
            foreach(Util::departamentos as $dpto){
                array_push($dptos, $dpto[0]);
            }
            $departamento = implode(',', $dptos);
        }
        $query = str_replace('__departamento__',$departamento, $query);

        if($ano_inicio == $ano_fim){
            $query = str_replace('__ano__'," AND C.dtainc LIKE '%".$ano_fim."%'", $query);
        } else{
            $query = str_replace('__ano__'," AND C.dtainc BETWEEN '".$ano_inicio."-01-01' AND '".$ano_fim."-12-31'", $query);
        }
        
        $result = DB::fetchAll($query);
        $data = $result;

        $export = new DadosExport([$data], 
        [
            'Código curso CEU', 
            'Código departamento', 
            'Departamento', 
            'Nome curso', 
            'Vagas', 
	        'Descrição', 
            'Objetivo', 
            'Justificativa', 
            'Formato', 
            'Data início', 
            'Data final', 
	        'Motivo curso a distância', 
            'Carga horária miníma', 
            'Carga horária total' 
        ]);

        return $this->excel->download($export, 'curso_CEU.xlsx');
    }

}
