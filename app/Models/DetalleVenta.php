<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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

    /**
     * the appends attributes for accesors.
     */
    protected $appends = [
        // 'mi_venta',
        // 'mi_producto',
        'sub_total',
    ];

    /**
     * Get mi venta.
     */
    public function getMiVentaAttribute()
    {
        return $this->venta;
    }
    
    /**
     * Get mi venta.
     */
    public function getSubTotalAttribute()
    {
        if ( $this->precio_x_gr == true) {
            return $this->gramos * $this->precio;
        }else {
            return $this->cantidad * $this->precio;
        }
    }

    /**
     * Get Venta
     */ 
    public function venta(): BelongsTo
    {
        return $this->belongsTo(Venta::class, 'venta_id');
    }
    
    /**
     * Get mi producto.
     */
    public function getMiProductoAttribute()
    {
        return $this->producto;
    }

    /**
     * Get producto
     */ 
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    /**
     * Get the detalleVenta
     */
    public function aditamentoVentas(): HasMany
    {
        return $this->hasMany(AditamentoVenta::class, 'detalle_venta_id', 'id');
    }
}
