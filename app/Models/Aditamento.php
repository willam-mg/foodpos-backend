<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Aditamento extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'descripcion',
        'producto_id',
        'aditamento_id',
        'numero_producto',
    ];

    /**
     * the appends attributes for accesors.
     */
    protected $appends = [
        'mi_aditamento',
        'mi_producto',
    ];

    /**
     * Get mi aditamento.
     */
    public function getMiAditamentoAttribute()
    {
        return $this->productoAditamento;
    }
    
    /**
     * Get mi producto.
     */
    public function getMiProductoAttribute()
    {
        return $this->producto;
    }

    /**
     * Get the producto type aditamento associated with the aditamento.
     */
    public function productoAditamento(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'aditamento_id');
    }
    
    /**
     * Get the prodcuto associated with the aditamento.
     */
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
