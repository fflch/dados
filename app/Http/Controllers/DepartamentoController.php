<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FiltrarDepartamentoRequest;
use DB;

class DepartamentoController extends Controller
{
    public function listarIC(Request $request, $departamento)
    {
        // Mapear os departamentos válidos

        $departamentosValidos = [
            'antropologia' => 'Antropologia',
            'ciencia-politica' => 'Ciência Política',
            'filosofia' => 'Filosofia',
            'geografia' => 'Geografia',
            'historia' => 'História',
            'letras-classicas-e-vernaculas' => 'Letras Clássicas e Vernáculas',
            'letras-modernas' => 'Letras Modernas',
            'letras-orientais' => 'Letras Orientais',
            'linguistica' => 'Linguística',
            'sociologia' => 'Sociologia',
            'teoria-literaria-e-literatura-comparada' => 'Teoria Literária e Literatura Comparada'
        ];

        // Verifica se o departamento existe
        if (!array_key_exists($departamento, $departamentosValidos)) {
            return abort(404, 'Departamento não encontrado');
        }

        $nomeDepartamento = $departamentosValidos[$departamento];

        // Conexão com o banco de dados 'etl'
        $db = DB::connection('etl');
        $projetos = $db->table('iniciacoes')
                    ->where('nome_departamento', 'LIKE', $nomeDepartamento)
                    ->get();

        return view('departamentos.geral', compact('projetos', 'nomeDepartamento'));
    }
}
