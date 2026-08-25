<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\ModelStatus\HasStatuses;


class Pedido extends Model
{
    use HasFactory;
    use HasStatuses;
    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
