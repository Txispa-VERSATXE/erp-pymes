<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Compra extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'compras';

    protected $fillable = [
        'proveedor_id',
        'usuario_id',
        'fecha_compra',
        'total',
        'estado',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleCompra::class, 'compra_id');
    }
}
