<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Productos;

class ProductosController extends Controller
{
    // Muestra todos los productos activos
    public function mostrarProductos()
    {
        $productos = Productos::where('activo', 'si')->get();
        return view('/secretaria.productos.productos', compact('productos'));
    }

    // Guarda un nuevo producto
    public function storeProductos(Request $request)
    {
        // Validación de los datos recibidos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
        ]);

        // Creación del producto
        Productos::create($request->all());

        // Redirecciona a la vista de productos con un mensaje de éxito
        return redirect()->route('productos')->with('status', 'Producto registrado correctamente');
    }

    // Muestra el formulario para agregar un nuevo producto
    public function crearProducto()
    {
        return view('/secretaria.productos.agregarProducto');
    }

    // Muestra el formulario de edición de un producto específico
    public function editarProducto($id)
    {
        $producto = Productos::findOrFail($id);
        return view('/secretaria.productos.editarProducto', compact('producto'));
    }

    // Actualiza la información de un producto específico
    public function updateProducto(Request $request, $id)
    {
        // Validación de los datos recibidos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
        ]);

        // Encuentra el producto y actualiza sus datos
        $producto = Productos::findOrFail($id);
        $producto->update($request->all());

        // Redirecciona a la vista de productos con un mensaje de éxito
        return redirect()->route('productos')->with('status', 'Producto actualizado correctamente');
    }

    // Marca a un producto como inactivo (eliminado)
    public function eliminarProducto($id)
    {
        $producto = Productos::findOrFail($id);
        $producto->update(['activo' => 'no']);

        return redirect()->route('productos')->with('status', 'Producto eliminado correctamente');
    }
}
