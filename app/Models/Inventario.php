<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Inventario extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'inventario';

    protected $fillable = [
        'producto_id',
        'stock',
        'umbral_min',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}