<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $fillable = [
        'id',
        'nome',
        'email',
    ];

    public function produtos()
    {
        try {
            return $this->belongsToMany('App\Produto', 'clientes_produtos');
        }  catch (\Exception $Exception) {
            abort(500, $Exception->getMessage());
        }
    }
}
