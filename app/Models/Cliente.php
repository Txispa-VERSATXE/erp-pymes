<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Cliente extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'clientes';

    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'direccion',
    ];

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'cliente_id');
    }
}