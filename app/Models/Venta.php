<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venta extends Model
{
    use HasFactory, SoftDeletes;

    protected $filalble = [
        'fecha',
        'hora',
        'descuento',
        'comentario',
        'estado',
        'cliente_id',
        'user_id',
        'punto_venta_id',
    ];
}
