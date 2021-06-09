<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserProductoController extends Controller
{
    public function index()
    {

        // $user_id= $request->user_id;
        $user=auth()->user();

        //$sql=DB::select('SELECT productos.nombre FROM `users_productos`, `productos` WHERE users_productos.user_id=?', [$user->id]);

        $productos = $user->productos;

        return response()->json($productos->toArray());
    }

    public function store(Request $request)
    {
        // $product=([
        //     'user_id'=>$request->user_id,
        //     'producto_id'=>$request->producto_id,
        // ]);

        $user=auth()->user();

        $input = $request->all();

        $productoId = $input["producto_id"];

        // Consultar si no existe ya
        $productosIds = $user->productos()->pluck('producto_id')->all();
        if (!in_array($productoId, $productosIds))
        {
            $user->productos()->attach($productoId);
        }
        else
        {
            return response()->json("Producto ya en la cesta");
        }

        return response()->json("Producto añadido");
    }

    public function destroy($producto)
    {
        $user=auth()->user();

        // Consultar si existe
        $productosIds = $user->productos()->pluck('producto_id')->all();
        if (in_array($producto, $productosIds))
        {
            $user->productos()->detach($producto);
        }
        else
        {
            return response()->json("Producto no presente en la cesta");
        }

        return response()->json("Producto eliminado");
    }
}
