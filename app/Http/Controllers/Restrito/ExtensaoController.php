<?php

namespace App\Http\Controllers\Restrito;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class ExtensaoController extends Controller
{
    public function index(){
        Gate::authorize('admin');
        return view('restrito.extensao');
    }

}
