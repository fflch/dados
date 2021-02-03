<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Uspdev\Replicado\Posgraduacao;

class Programa extends Model
{
    public static function index(){
        return Posgraduacao::programas(8);
    }
}
