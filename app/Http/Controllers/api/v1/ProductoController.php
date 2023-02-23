<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\PuntoVenta;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\ImageTrait;

class ProductoController extends Controller
{
    use ImageTrait;

    public function create(Request $request) {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'nombre' => ['required'],
                'descripcion' => ['required'],
                'foto' => ['nullable'],
                'precio' => ['required'],
                'precio_x_gr' => ['required'],
                'es_producto' => ['required'],
                'es_aditamento' => ['required'],
                'publicado' => ['required'],
                'punto_venta_id' => ['nullable'],
                'comentario' => ['nullable'],
            ]);

            if ($validator->fails()) {
                http_response_code(422);
                throw new \Exception($validator->errors()->first());
            }
            $producto = new Producto();
            $producto->nombre = $request->nombre;
            $producto->descripcion = $request->descripcion;
            $producto->precio = $request->precio;
            $producto->precio_x_gr = $request->precio_x_gr;
            $producto->es_producto = $request->es_producto;
            $producto->es_aditamento = $request->es_aditamento;
            $producto->publicado = $request->publicado;
            $producto->punto_venta_id = $request->punto_venta_id;
            $producto->comentario = $request->comentario;
            $producto->save();

            $image = $request->foto;
            if ($image) {
                $this->saveImage($image, $producto, 'producto');
            }

            DB::commit();
            return response()->json($producto, 201);

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'id' => ['required'],
                'nombre' => ['required'],
                'descripcion' => ['required'],
                'foto' => ['nullable'],
                'precio' => ['required'],
                'precio_x_gr' => ['required'],
                'es_producto' => ['required'],
                'es_aditamento' => ['required'],
                'publicado' => ['required'],
                'punto_venta_id' => ['nullable'],
                'comentario' => ['nullable'],
            ]);

            if ($validator->fails()) {
                http_response_code(422);
                throw new \Exception($validator->errors()->first());
            }
            $producto = Producto::findOrFail($request->id);
            $producto->nombre = $request->nombre;
            $producto->descripcion = $request->descripcion;
            $producto->precio = $request->precio;
            $producto->precio_x_gr = $request->precio_x_gr;
            $producto->es_producto = $request->es_producto;
            $producto->es_aditamento = $request->es_aditamento;
            $producto->publicado = $request->publicado;
            $producto->punto_venta_id = $request->punto_venta_id;
            $producto->comentario = $request->comentario;
            $producto->save();
            
            $image = $request->foto;
            if ($image) {
                $this->saveImage($image, $producto, 'afiliado', true);
            }

            DB::commit();
            return response()->json($producto, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    function search(Request $request) {
        $data = Producto::when($request->nombre, function ($query) use($request) {
                $query->where(DB::Raw("nombre"), 'like', '%' . $request->nombre . '%');
            })
            ->when(boolval($request->publicado), function ($query) use($request) {
                $query->where(DB::Raw("publicado"), '=', boolval($request->publicado));
            })
            ->when(intval($request->punto_venta_id), function ($query) use($request) {
                $query->where(DB::Raw("punto_venta_id"), '=', intval($request->punto_venta_id));
            })
            ->orderBy('id', 'DESC')
            ->paginate(5);
        return response()->json($data, 200);
    }

    public function show($id)
    {
        $producto = Producto::findOrFail($id);
        return response()->json($producto, 200);
    }

    public function delete($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();
        return response()->json("Se elimino correctamente", 200);
    }

    public function puntosVenta() {
        return PuntoVenta::all();
    }
}
