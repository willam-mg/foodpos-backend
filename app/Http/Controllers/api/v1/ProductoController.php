<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Aditamento;
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

    public function update(int $id, Request $request)
    {
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
            $producto = Producto::findOrFail($id);
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
                $this->saveImage($image, $producto, 'afiliado', $producto->src_foto?true:false );
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
                $query->where("nombre", 'like', '%' . $request->nombre . '%');
            })
            ->when(boolval($request->publicado), function ($query) use($request) {
                $query->where("publicado", '=', boolval($request->publicado));
            })
            ->when(boolval($request->es_aditamento), function ($query) use($request) {
                $query->where("es_aditamento", '=', boolval($request->es_aditamento));
            })
            ->when(intval($request->punto_venta_id), function ($query) use($request) {
                $query->where("punto_venta_id", '=', intval($request->punto_venta_id));
            })
            ->orderBy('id', 'DESC')
            ->paginate(5);
        return response()->json($data, 200);
    }

    public function show(int $id)
    {
        $producto = Producto::findOrFail($id);
        return response()->json($producto, 200);
    }

    public function delete($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();
        return response()->json([
            "message"=> "Se elimino correctamente",
        ], 200);
    }

    public function puntosVenta() {
        return PuntoVenta::all();
    }

    public function addAditamento(Request $request) {
        DB::beginTransaction();
        try {
            $producto = Producto::findOrFail($request->producto_id);
            $count = $producto->aditamentos()->count();
            $exists = $producto->aditamentos()
                ->where([
                    'producto_id'=>$request->producto_id,
                    'aditamento_id'=>$request->aditamento_id
                ])
                ->exists();
            if ($exists) {
                throw new \Exception("Aditamento ya existe");
            }

            $aditamento = new Aditamento();
            $aditamento->descripcion = $request->descripcion;
            $aditamento->producto_id = $request->producto_id;
            $aditamento->aditamento_id = $request->aditamento_id;
            $aditamento->numero_producto = $count + 1;
            $aditamento->save();

            DB::commit();
            return response()->json($producto, 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        
    }

    public function removeAditamento($id) {
        $aditamento = Aditamento::findOrFail($id);
        $aditamento->delete();
        return response()->json([
            "message" => "Se elimino correctamente",
        ], 200);
    }
}
