<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Utils\Util;

class RestritoController extends Controller
{
    public function restrito()
    {
        Gate::authorize('admin');
        
        return view('restrito', [ 'areas' => Util::getAreas()]);
    }
}
