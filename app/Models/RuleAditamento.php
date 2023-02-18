<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RuleAditamento extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'producto_id',
        'aditamento_id',
        'cantidad_maxima',
    ];
}
