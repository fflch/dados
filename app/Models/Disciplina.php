<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Disciplina extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'disciplinas';
    protected $hidden = ['id','updated_at_sync'];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }
}