<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AditamentoVenta extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'numero_producto',
        'detalle_venta_id',
        'aditamento_id',
    ];

    /**
     * the appends attributes for accesors.
     */
    protected $appends = [
        'mi_aditamento',
        'mi_detalle_venta',
    ];

    /**
     * Get mi venta.
     */
    public function getMiAditamentoAttribute()
    {
        return $this->aditamento;
    }

    /**
     * Get mi venta.
     */
    public function getMiDetalleVentaAttribute()
    {
        return $this->detalleVenta;
    }

    /**
     * Get Aditamento
     */
    public function aditamento(): BelongsTo
    {
        return $this->belongsTo(Aditamento::class, 'aditamento_id');
    }

    /**
     * Get detalleVenta
     */
    public function detalleVenta(): BelongsTo
    {
        return $this->belongsTo(DetalleVenta::class, 'detalle_venta_id');
    }
}
