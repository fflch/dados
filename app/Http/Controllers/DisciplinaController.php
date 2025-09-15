<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Uspdev\Replicado\DB;
use App\Utils\ReplicadoTemp;

class DisciplinaController extends Controller
{
    public function turmas(){
        return view('disciplinas.turmas');
    }

    public function prefix($prefix){
        $turmas = ReplicadoTemp::turmas($prefix);

        return view('disciplinas.turma',[
            'prefix' => $prefix,
            'turmas' => $turmas,
        ]);
    }

    public function concatenate($prefix){
        $turmas = ReplicadoTemp::turmas($prefix);

        return view('disciplinas.concatenate',[
            'prefix' => $prefix,
            'turmas' => $turmas,
        ]);
    }
}