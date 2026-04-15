<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Venta extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'ventas';

    protected $fillable = [
        'cliente_id',
        'usuario_id',
        'fecha_venta',
        'total',
        'estado',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'venta_id');
    }
}