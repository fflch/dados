<?php

namespace App\Models;
use MongoDB\Laravel\Eloquent\Model;

class Docente extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'docentes';
}
