<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productos;

class ProductosController extends Controller
{
    public function mostrarProductos(Request $request)
    {
        $query = Productos::query();

        // Filtros de búsqueda
        if ($request->has('busqueda') && $request->busqueda != '') {
            $terms = explode(' ', $request->busqueda);
            $query->where(function($q) use ($terms) {
                foreach ($terms as $term) {
                    $q->orWhere('nombre', 'like', '%' . $term . '%');
                }
            });
        }

        $productos = $query->where('activo', 'si')->get();
        return view('secretaria.productos.productos', compact('productos'));
    }

    public function storeProductos(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'cantidad' => 'required|numeric|min:0',
        ]);

        Productos::create($request->all());

        return redirect()->route('productos')->with('status', 'Producto registrado correctamente');
    }

    public function editarProducto($id)
    {
        $producto = Productos::findOrFail($id);
        return response()->json($producto);
    }

    public function updateProducto(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'cantidad' => 'required|numeric|min:0',
        ]);

        $producto = Productos::findOrFail($id);
        $producto->update($request->all());

        return redirect()->route('productos')->with('status', 'Producto actualizado correctamente');
    }

    public function eliminarProducto($id)
    {
        $producto = Productos::findOrFail($id);
        $producto->update(['activo' => 'no']);

        return redirect()->route('productos')->with('status', 'Producto eliminado correctamente');
    }
}
