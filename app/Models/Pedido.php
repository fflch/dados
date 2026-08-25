<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Pedido extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    /* protected function assunto(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Str::ascii($value),
        );
    }

    protected function descricao(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => Str::ascii($value),
        );
    } */

}
