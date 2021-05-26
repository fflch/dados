<?php

namespace App\Http\Controllers;

use App\Utils\Util;

class RestritoController extends Controller
{
    public function restrito()
    {
        $this->authorize('admins');
        $departamentos = Util::departamentos;
        $cursos = Util::cursos;
        $areas = Util::getAreas();
        return view('restrito', compact('departamentos', 'cursos', 'areas'));
    }
}
