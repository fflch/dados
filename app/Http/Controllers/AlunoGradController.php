<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Uspdev\Replicado\DB;
use App\Utils\ReplicadoTemp;
use App\Utils\Util;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Illuminate\Support\Facades\Log;


class AlunoGradController extends Controller
{
    public function show(Request $request){
        $data = Util::query('contagem_alunosGrad');
        $total = 0;
        foreach ($data as $curso){
            $total += $curso['qtd'];
        }
        $data[] = ['nomcur' => 'Total', 'qtd' => $total];

        Cache::put($request->session()->getId().'contagem_alunosGrad',$data,600);

        return view('alunoGrad',['cursos' => $data]);
    }

    public function planilha(Request $request, Excel $excel){
        
        $data = Cache::get($request->session()->getId().'contagem_alunosGrad');
        
        if(!isset($data)){
            $data = Util::query('contagem_alunosGrad');
            $total = 0;
            foreach ($data as $curso){
                $total += $curso['qtd'];
            }
            $data[] = ['nomcur' => 'Total', 'qtd' => $total];

        }
    
        $export = new DadosExport([$data],
        [
            'Curso',
            'Quantidade'
        ]);

        return $excel->download($export,'Alunos Graduação por Curso.xlsx');
    
    }
}