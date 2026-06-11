<?php

namespace App\Models;
use MongoDB\Laravel\Eloquent\Model;

class Estagiario extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'estagiarios';
    protected $hidden = ['id','_id','updated_at_sync'];

}
