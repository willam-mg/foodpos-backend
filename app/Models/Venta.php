<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    /**
     * the appends attributes for accesors.
     */
    protected $appends = [
        // 'mi_detalle_venta',
    ];

    /**
     * Get mis aditamentos.
     */
    public function getMiDetalleVentaAttribute()
    {
        return $this->detalleVenta;
    }

    /**
     * Get the detalleVenta
     */
    public function detalleVenta(): HasMany
    {
        return $this->hasMany(DetalleVenta::class, 'venta_id', 'id');
    }
}
