<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{
    protected $table = 'disciplinas';

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }
}