<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aditamento extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'descripcion',
        'producto_id',
        'aditamento_id',
        'numero_producto',
    ];

}
