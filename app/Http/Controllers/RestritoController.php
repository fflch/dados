<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;

class RestritoController extends Controller
{
    public function restrito()
    {
        Gate::authorize('admin');
        
        return view('restrito');
    }
}
