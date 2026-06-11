<?php

namespace App\Models;
use MongoDB\Laravel\Eloquent\Model;

class Intercambista extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'intercambistas';
    protected $hidden = ['id','_id','updated_at_sync'];

}
