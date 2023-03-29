<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\AditamentoVenta;
use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VentaController extends Controller
{
    private function formatVenta(Venta $venta) {
        return [
            'id'=>$venta->id,
            'fecha'=>$venta->fecha,
            'hora'=>$venta->hora,
            'descuento'=>$venta->descuento,
            'comentario'=>$venta->comentario,
            'estado'=>$venta->estado,
            'cliente_id'=>$venta->cliente_id,
            'user_id'=>$venta->user_id,
            'punto_venta_id'=>$venta->punto_venta_id,
            'detalleVenta'=>$venta->detalleVenta,
            'total'=>$venta->total,
            'mi_punto_venta'=>$venta->puntoVenta,
        ];
    }

    public function index(Request $request) {
        $data = Venta::when($request->filterFechaInicio, function ($query) use ($request) {
                $query->where("fecha", '<=',  $request->filterFechaInicio);
            })
            ->when($request->filterFechaFin, function ($query) use ($request) {
                $query->where("fecha", '>=',  $request->filterFechaFin);
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
                'detalleVenta' => ['required'],
            ]);

            if ($validator->fails()) {
                http_response_code(422);
                throw new \Exception($validator->errors()->first());
            }
            // create a venta
            $venta = new Venta();
            $venta->fecha = date('Y-m-d');
            $venta->hora = date('H:i:s');
            $venta->descuento = $request->descuento? $request->descuento: 0;
            $venta->comentario = $request->comentario;
            $venta->user_id = Auth::user()->id;
            $venta->punto_venta_id = $request->punto_venta_id? $request->punto_venta_id: Auth::user()->punto_venta_id;
            $venta->save();

            $detalle = $request->detalleVenta? $request->detalleVenta:[];
            foreach ($detalle as $key => $item) {
                $detalleVenta = new DetalleVenta();
                $producto = Producto::find(intval($item['producto_id']));
                $detalleVenta->nombre_producto = $producto->nombre;
                $detalleVenta->precio_x_gr = $producto->precio_x_gr;
                $detalleVenta->precio = $producto->precio;
                $detalleVenta->cantidad = $item['cantidad'];
                $detalleVenta->descuento = $item['descuento']? $item['descuento']: 0;
                $detalleVenta->gramos = $producto->precio_x_gr? $item['gramos']: null;
                $detalleVenta->venta_id = $venta->id;
                $detalleVenta->producto_id = $producto->id;
                $detalleVenta->save();
                if($item['aditamentos_venta']) {
                    $aditamentosVenta = $item['aditamentos_venta']? $item['aditamentos_venta']: [];
                    foreach ($aditamentosVenta as $key1 => $itemAditamento) {
                        $aditamentosVenta = new AditamentoVenta();
                        $aditamentosVenta->numero_producto = $itemAditamento['numero_producto'];
                        $aditamentosVenta->detalle_venta_id = $detalleVenta->id;
                        $aditamentosVenta->aditamento_id = $itemAditamento['aditamento_id'];
                        $aditamentosVenta->save();
                    }
                }
            }

            DB::commit();
            return response()->json($this->formatVenta($venta), 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function show(int $id)
    {
        $venta = Venta::findOrFail($id);
        return response()->json($this->formatVenta($venta), 200);
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
