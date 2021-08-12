<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Uspdev\Replicado\DB;
use Illuminate\Http\Request;
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

        $campos = [
            'Número USP',
            'Nome',
            'Data de início'
        ];

        if($pessoa == 'alunos_estrangeiros'){
            $result = ReplicadoTemp::listarAlunoEstrangeiro($ano);
        } else if($pessoa == 'alunos_intercambistas'){
            array_push($campos, 'Curso');
            $result = ReplicadoTemp::listarAlunosIntercambistas($ano, $curso);
        } else if($pessoa == 'docentes_estrangeiros'){
            array_push($campos, 'Setor');
            $result = ReplicadoTemp::listarDocentesEstrangeiros($ano, $setor);

            $data = [];
            
            if($result){
                foreach($result as $r){
                    $aux = [];
                    $aux['codpes'] = $r['codpes'];
                    $aux["nompes"] = $r["nompes"];
                    $aux["dtainiatvitb"] = $r["dtainiatvitb"];
                    
                    $curso_dpto = Util::retornarCursoGrdPorDepartamento($r['nomabvset'])['nome_curso'];
                    $aux['curso'] = $curso_dpto;
                    array_push($data,$aux);
                }
            }
            $result = $data;
           
        }   

        $export = new DadosExport([$result], $campos);
        
        return $this->excel->download($export, "$pessoa".'_'.$ano.'intercambio.xlsx');
        
    }
}
