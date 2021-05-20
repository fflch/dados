<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RestritoController extends Controller
{
    public function restrito()
    {
        $this->authorize('admins');
        return view('restrito');
    }
}
