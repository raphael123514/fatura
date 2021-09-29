<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = 'produtos';
    protected $fillable = [
        'id',
        'nome',
        'categoria_id',
        'estoque',
        'preco',
    ];

}
