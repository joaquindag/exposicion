<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos=Producto::all();
        return response()->json($productos);
    }

    public function store(Request $request)
    {
        //Validacion
        $request->validate([
            'nombre'=>'required',
            'descripcion'=>'required',
            'precio'=>'required'
        ]);

        //Guardar en la BBDD

        $product=Producto::create([
            'nombre'=>$request->nombre,
            'descripcion'=>$request->descripcion,
            'precio'=>$request->precio
        ]);

        //Respuesta
        return response()->json($product);
    }

    public function update(Request $request, Producto $producto)
    {
        //Validacion
        $request->validate([
            'nombre'=>'required',
            'descripcion'=>'required',
            'precio'=>'required'
        ]);

        //Guardar en la BBDD

        $producto->update([
            'nombre'=>$request->nombre,
            'descripcion'=>$request->descripcion,
            'precio'=>$request->precio
        ]);

        //Respuesta
        return response()->json($producto);
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return response()->json($producto);
    }
}
