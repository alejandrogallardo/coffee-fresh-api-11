<?php

namespace App\Http\Controllers;

use App\Http\Resources\PedidoCollection;
use App\Models\Pedido;
use App\Models\PedidoProducto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new PedidoCollection(Pedido::with('user')->with('productos')->where('estado', 0)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $pedido = New Pedido;
        $pedido->user_id = Auth::user()->id;
        $pedido->total = $request->total;
        $pedido->save();
        // obtener pedido id
        $id = $pedido->id;
        // obtener productos
        $productos = $request->productos;
        // Formatear arreglo
        $pedido_producto = [];
        foreach ($productos as $producto)
        {
            $pedido_producto[] = [
              'pedido_id' => $id,
              'producto_id' => $producto['id'],
              'cantidad' => $producto['cantidad'],
              'created_at' => Carbon::now(),
              'updated_at' => Carbon::now(),
            ];
        }
        // almacenar en db // insert permmite insertar un arreglo
        PedidoProducto::insert($pedido_producto);
        return [
            'message' => 'Pedido realizado correctamente.'
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pedido $pedido)
    {
        $pedido->estado = 1;
        $pedido->save();
        return $pedido;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {
        //
    }
}
