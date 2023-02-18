<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetalleVenta extends Model
{
    use HasFactory, SoftDeletes;

    protected $filalble = [
        'nombre_producto',
        'precio_x_gr',
        'precio',
        'cantidad',
        'descuento',
        'gramos',
        'venta_id',
        'producto_id',
    ];
}
