<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PuntoVenta extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'restaurante',
        'nombre_punto_venta',
        'foto',
        'direccion',
        'telefono',
        'telefono_pedidos',
        'hora_apertura',
        'hora_cierre',
    ];
}
