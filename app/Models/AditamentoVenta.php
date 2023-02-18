<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AditamentoVenta extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'numero_producto',
        'detalle_venta_id',
        'aditamento_id',
    ];
}
