<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use HasFactory, SoftDeletes;

    protected $filalble = [
        'nombre',
        'descripcion',
        'src_foto',
        'precio',
        'precio_x_gr',
        'es_producto',
        'es_aditamento',
        'publicado',
        'punto_venta_id',
        'comentario',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'precio_x_gr' => 'boolean',
        'es_producto'=> 'boolean',
        'es_aditamento' => 'boolean',
    ];

    /**
     * the appends attributes for accesors.
     */
    protected $appends = [
        'foto',
        'foto_thumbnail',
        'foto_thumbnail_sm',
        'punto_venta',
        'mi_categoria',
    ];

    /**
     * get foto attribute
     */
    public function getFotoAttribute()
    {
        return $this->src_foto ? url('/') . '/storage/uploads/' . $this->src_foto : null;
    }

    /**
     * Get accesor foto thumbnail.
     */
    public function getFotoThumbnailAttribute()
    {
        return $this->src_foto ? url('/') . '/storage/uploads/thumbnail/' . $this->src_foto : null;
    }
    /**
     * Get accesor foto small thumbnail.
     */
    public function getFotoThumbnailSmAttribute()
    {
        return $this->src_foto ? url('/') . '/storage/uploads/thumbnail-small/' . $this->src_foto : null;
    }

    /**
     * Get the puntoVenta associated with the Producto.
     */
    public function getPuntoVentaAttribute()
    {
        return $this->puntoVenta();
    }
    
    /**
     * Get the puntoVenta associated with the Producto.
     */
    public function getMiCategoriaAttribute()
    {
        return $this->categoria;
    }

    /**
     * Get the phone associated with the user.
     */
    public function puntoVenta(): BelongsTo
    {
        return $this->belongsTo(PuntoVenta::class, 'punto_venta_id');
    }

    /**
     * Get the phone associated with the user.
     */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(CategoriaProducto::class, 'categoria_producto_id');
    }

    /**
     * Get the aditamentos
     */
    public function aditamentos(): HasMany
    {
        return $this->hasMany(Aditamento::class, 'producto_id', 'id');
    }
}
