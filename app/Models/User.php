<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    const ROLE_ADMINISTRADOR = 2;
    const ROLE_VENDEDOR = 3;
    const ESTADO_ACTIVO = 2;
    const ESTADO_BLOQUEADO = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'turno',
        'foto',
        'punto_venta_id',
        'estado'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * the appends attributes for accesors.
     */
    protected $appends = [
        'foto',
        'foto_thumbnail',
        'foto_thumbnail_sm',
        'mi_punto_venta',
    ];

    /**
     * get foto attribute
     */
    public function getFotoAttribute()
    {
        return $this->src_foto? url('/').'/uploads/'.$this->src_foto: null;
    }

    /**
     * Get accesor foto thumbnail.
     */
    public function getFotoThumbnailAttribute()
    {
        return $this->src_foto ? url('/') . '/uploads/thumbnail/' . $this->src_foto: null;
    }
    /**
     * Get accesor foto small thumbnail.
     */
    public function getFotoThumbnailSmAttribute()
    {
        return $this->src_foto ? url('/') . '/uploads/thumbnail-small/' . $this->src_foto: null;
    }

    /**
     * Get the phone associated with the user.
     */
    public function getMiPuntoVentaAttribute()
    {
        return $this->puntoVenta;
    }

    /**
     * Get the phone associated with the user.
     */
    public function puntoVenta(): HasOne
    {
        return $this->hasOne(PuntoVenta::class, 'id', 'punto_venta_id');
    }

    /**
     * Get the codigos
     */
    public function ventas()
    {
        return $this->hasMany(Venta::class, 'user_id', 'id');
    }
}
