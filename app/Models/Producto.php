<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Producto extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'productos';

    protected $fillable = [
        'nombre',
        'categoria',
        'precio',
        'stock',
        'umbral_min',
    ];

    public function inventario()
    {
        return $this->hasOne(Inventario::class, 'producto_id');
    }
}