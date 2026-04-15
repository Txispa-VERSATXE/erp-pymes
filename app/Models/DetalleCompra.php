<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class DetalleCompra extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'detalle_compras';

    protected $fillable = [
        'compra_id',
        'producto_id',
        'cantidad',
        'costo_unit',
    ];

    public function compra()
    {
        return $this->belongsTo(Compra::class, 'compra_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}