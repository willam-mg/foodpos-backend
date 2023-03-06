<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VentaController extends Controller
{
    public function index(Request $request) {
        $data = Venta::when($request->fecha, function ($query) use ($request) {
                $query->where("fecha", 'like', '%' . $request->fecha . '%');
            })
            ->orderBy('id', 'DESC')
            ->paginate(5);
        return response()->json($data, 200);
    }

    public function create(Request $request) {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'fecha' => ['nullable'],
                'hora' => ['nullable'],
                'descuento' => ['nullable'],
                'comentario' => ['nullable'],
                'cliente_id' => ['nullable'],
                'punto_venta_id' => ['nullable'],
                'detalle_productos' => ['required'],
            ]);

            if ($validator->fails()) {
                http_response_code(422);
                throw new \Exception($validator->errors()->first());
            }
            // create a venta
            $venta = new Venta();
            $venta->fecha = date('Y-m-d');
            $venta->hora = date('H:i:s');
            $venta->descuento = $request->descuento;
            $venta->comentario = $request->comentario;
            $venta->user_id = Auth::user()->id;
            $venta->punto_venta_id = Auth::user()->punto_venta_id;
            $venta->save();

            $detalle = $request->detalle_productos;
            foreach ($detalle as $key => $item) {
                $detalleVenta = new DetalleVenta();
                $producto = Producto::findOrFail($item['producto_id']);
                $detalleVenta->nombre_producto = $producto->nombre;
                $detalleVenta->precio_x_gr = $producto->precio_x_gr;
                $detalleVenta->precio = $producto->precio;
                $detalleVenta->cantidad = $item['cantidad'];
                $detalleVenta->descuento = $item['descuento'];
                $detalleVenta->gramos = $producto->precio_x_gr? $item['gramos']: null;
                $detalleVenta->venta_id = $venta->id;
                $detalleVenta->producto_id = $producto->id;
                $detalleVenta->save();
            }

            DB::commit();
            return response()->json($venta, 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function show(int $id)
    {
        $venta = Venta::findOrFail($id);
        return response()->json($venta, 200);
    }

    public function delete($id)
    {
        $venta = Venta::findOrFail($id);
        $venta->delete();
        return response()->json([
            "message" => "Se elimino correctamente",
        ], 200);
    }
}
