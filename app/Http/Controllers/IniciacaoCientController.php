<?php

namespace App\Http\Controllers;

use App\Exports\IniciacoesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use DB;

class IniciacaoCientController extends Controller
{
    public function listarIC()
    {
        // count
        $db = DB::connection('etl');
        $alunos_ic_total = $db->table('iniciacoes')->count('*');

        // lista projetos ic total
        $alunos_ic_historia = $db->table('iniciacoes')->where('nome_departamento', 'LIKE', 'H%')->get();

        return view('alunosIc', [
            'alunos_ic_total' => $alunos_ic_total,
            'alunos_ic_historia' => $alunos_ic_historia
        ]);
    }

    // Mudei o nome do método para exportarExcel
    public function exportarExcel()
    {
        return Excel::download(new IniciacoesExport(), 'iniciacoes.xlsx');
    }
}
