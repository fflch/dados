<?php

namespace App\Http\Controllers;

use Uspdev\Replicado\Pessoa;

class DocenteController extends Controller
{
    public function listarDocentesAtivosFFLCH()
    {
        // Listando apenas os docentes ativos
        $doc_ativos = Pessoa::listarDocentes(null, 'A'); // Passando 'A' explicitamente para docentes ativos
        //dd($doc_ativos);
        return view('docentes.ativos', ['doc_ativos' => $doc_ativos]);
    }

    public function listarDocentesInativosFFLCH()
    {
        // Listando docentes inativos
        $doc_inativos = Pessoa::listarDocentes(null, '2'); // '2' para docentes inativos
        return view('docentes.inativos', ['doc_inativos' => $doc_inativos]);
    }

    public function listarAuxilio()
    {
        // Listar auxílio dos docentes
        $aux = Pessoa::listarVinculosAtivos();
        return view('docentes.auxilio', ['aux' => $aux]);
    }
}
