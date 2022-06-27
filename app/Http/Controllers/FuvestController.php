<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use App\Utils\ReplicadoTemp;
use Illuminate\Http\Request;
use Uspdev\Replicado\DB;
use Uspdev\Replicado\Graduacao;
use App\Models\ComissaoPesquisa;
use App\Utils\Util;

class FuvestController extends Controller
{
    private $excel;

    public function socioeconomico(Excel $excel, Request $request){
        $this->authorize('admins');
       
        $this->excel = $excel;

        $curso = $request->curso ?? 1;
        $ano = $request->ano ?? Date('Y');
        
        $data =  ReplicadoTemp::obterQuestionarioSocioeconomicoFuvest($ano, $curso);
        

        $export = new DadosExport([$data], array_keys($data[0]));

        return $this->excel->download($export, Util::cursos[$curso] . ' ('. $ano . ') '. 'QuestionarioSocioeconomicoFuvest.xlsx');

    }   

}