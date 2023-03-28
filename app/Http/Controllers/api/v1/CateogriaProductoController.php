<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\CategoriaProducto;
use Illuminate\Http\Request;

class CateogriaProductoController extends Controller
{
    public function list() {
        return CategoriaProducto::all();
    }
}
