<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\Util;
class RestritoController extends Controller
{
    public function restrito()
    {
        $this->authorize('admins');
        $departamentos = Util::departamentos;

        return view('restrito', compact('departamentos'));
    }
}
