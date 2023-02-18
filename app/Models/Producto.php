<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use HasFactory, SoftDeletes;

    protected $filalble = [
        'nombre',
        'descripcion',
        'foto',
        'precio',
        'precio_x_gr',
        'es_producto',
        'es_aditamento',
        'publicado',
        'punto_venta_id',
        'comentario',
    ];
}
