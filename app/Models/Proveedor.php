<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Proveedor extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'proveedores';

    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'direccion',
    ];

    public function compras()
    {
        return $this->hasMany(Compra::class, 'proveedor_id');
    }
}