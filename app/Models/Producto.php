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
     * Get the phone associated with the user.
     */
    public function getPuntoVentaAttribute()
    {
        return $this->puntoVenta();
    }

    /**
     * Get the phone associated with the user.
     */
    public function puntoVenta()
    {
        return $this->hasOne(PuntoVenta::class, 'id', 'punto_venta_id');
    }
}
