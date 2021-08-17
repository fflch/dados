<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use App\Utils\ReplicadoTemp;
use Illuminate\Http\Request;
use Uspdev\Replicado\DB;
use Uspdev\Replicado\Graduacao;
use App\Models\ComissaoPesquisa;


class BolsasController extends Controller
{
    private $excel;

    public function listarBolsas(Excel $excel, Request $request){
        $this->authorize('admins');
        $this->excel = $excel;

        $curso = $request->curso ?? 1;
        $ano = $request->ano ?? Date('Y');
        $tipos =  ReplicadoTemp::listarBolsas($ano, $curso);
      
        
        $cursos = ($curso == 1 ) ? Graduacao::obterCodigosCursos() : [$curso];
        

        $ic = ComissaoPesquisa::where('tipo','IC')->where('bolsa', 'true')->where('ano_proj', (int)$ano)->whereIn('cod_curso', $cursos)->get()->toArray();

        $data = [];
        foreach($tipos as $tipo){
            $result = ReplicadoTemp::contarBeneficiantesPorBolsa($ano, $curso, $tipo['codbnfalu']);
            if(!isset($result['computed']) || $result['computed'] == 0 || $result == false) continue;
            $data[$tipo['nombnfloc']] = $result['computed'];
        }
        $data['Iniciação científica (Bolsa - PIBIC)'] = sizeof($ic);

        
        

        $export = new DadosExport([$data], array_keys($data));

        return $this->excel->download($export, 'BolsasGraduacao.xlsx');

    }

}