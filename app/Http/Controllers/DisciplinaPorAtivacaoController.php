<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class DisciplinaPorAtivacaoController extends Controller
{
    public function listarPorAtivacao(Request $request)
    {
        // Recebe o código da disciplina (default é 'FLG')
        $cod_disc = $request->get('cod_disc', 'FLG');

        // Conexão ao banco de dados
        $bd = DB::connection('etl');

        // Contar total de disciplinas baseado no código
        $total_disciplinas = $bd->table('disciplinas_graduacao')
            ->where('codigo_disciplina', 'LIKE', "{$cod_disc}%")
            ->count();

        // Obter disciplinas ativas
        $disciplinas_ativas = $bd->table('disciplinas_graduacao')
            ->where('codigo_disciplina', 'LIKE', "{$cod_disc}%")
            ->whereNull('data_desativacao_disciplina')
            ->get();

        // Obter disciplinas inativadas
        $disciplinas_inativadas = $bd->table('disciplinas_graduacao')
            ->where('codigo_disciplina', 'LIKE', "{$cod_disc}%")
            ->whereNotNull('data_desativacao_disciplina')
            ->get();

        // Obter os prefixos diferentes de codigo_disciplina
        $prefixos = $bd->table('disciplinas_graduacao')
            ->select(DB::raw('LEFT(codigo_disciplina, 3) AS prefixo'))
            ->groupBy('prefixo')
            ->get();

        // Retornar a view com os dados necessários
        return view('disciplinas_inativadas', [
            'cod_disc' => $cod_disc,
            'total_disciplinas' => $total_disciplinas,
            'disciplinas_ativas' => $disciplinas_ativas,
            'disciplinas_inativadas' => $disciplinas_inativadas,
            'prefixos' => $prefixos, // Passar os prefixos para a view
        ]);
    }
}
