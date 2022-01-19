<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClienteProduto extends Model
{
    protected $table = 'clientes_produtos';
    protected $fillable = [
        'produto_id',
        'cliente_id',
    ];
}
