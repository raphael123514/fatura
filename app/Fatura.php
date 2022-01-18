<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fatura extends Model
{
    protected $table = 'faturas';
    protected $fillable = [
        'id',
        'valor',
        'data',
        'data_vencimento',
        'id_cliente',
    ];
}
