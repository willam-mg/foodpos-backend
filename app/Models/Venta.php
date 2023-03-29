<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'total',
    ];

    /**
     * the appends attributes for accesors.
     */
    protected $appends = [
        // 'mi_detalle_venta',
        'total',
        'mi_punto_venta'
    ];

    /**
     * Get mis aditamentos.
     */
    public function getMiDetalleVentaAttribute()
    {
        return $this->detalleVenta;
    }

    /**
     * Get mis aditamentos.
     */
    public function getTotalAttribute()
    {
        $total = 0;
        foreach ($this->detalleVenta as $key => $item) {
            $total += $item->sub_total;
        }
        return $total;
    }
    
    /**
     * Get mis aditamentos.
     */
    public function getMiPuntoVentaAttribute()
    {
        return $this->puntoVenta;
    }

    /**
     * Get the detalleVenta
     */
    public function detalleVenta(): HasMany
    {
        return $this->hasMany(DetalleVenta::class, 'venta_id', 'id');
    }

    /**
     * Get the phone associated with the user.
     */
    public function puntoVenta(): BelongsTo
    {
        return $this->belongsTo(PuntoVenta::class, 'punto_venta_id');
    }
}
