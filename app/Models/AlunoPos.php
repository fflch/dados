<?php

namespace App\Models;
use MongoDB\Laravel\Eloquent\Model;

class AlunoPos extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'alunosPos';
    protected $hidden = ['id','_id','updated_at_sync'];
}
