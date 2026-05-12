<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Muestra todos los productos registrados.
     * @return \Illuminate\Http\JsonResponse
     * @author Nicolas hernandez
     */
    public function index()
    {
        return response()->json(Product::all());
    }

    /**
     * Almacena un nuevo producto. Requisito: Solo Admin[cite: 101].
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $product = Product::create($request->all());

        return response()->json([
            'message' => 'Producto registrado exitosamente',
            'product' => $product
        ], 201);
    }

    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return response()->json(['product' => $product], 200);
    }

    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());

        return response()->json([
            'message' => '¡Producto actualizado con éxito!',
            'data' => $product
        ], 200);
    }

    public function destroy(string $id)
    {
        $product = Product::find($id);
        if(!$product){
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }
        $product->delete();
        return response()->json(['message' => 'Producto eliminado exitosamente'], 200);
    }

    /**
     * Realizar la compra y descontar stock[cite: 103, 106].
     * Valida disponibilidad de inventario.
     * * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author Nicolas Hernandez
     * @since 2026/05
     */
    public function purchase(Request $request)
    {
        // El documento pide validar disponibilidad 
        $items = $request->items; 

        if (!$items || count($items) === 0) {
            return response()->json(['message' => 'El carrito está vacío'], 400);
        }

        foreach ($items as $item) {
            $product = Product::find($item['id']);
            
            // Regla: No se puede comprar si el stock es insuficiente [cite: 109]
            if (!$product || $product->stock < 1) {
                return response()->json([
                    'message' => 'Stock insuficiente para: ' . ($product->name ?? 'Producto desconocido')
                ], 400);
            }
            
            // Descontar inventario 
            $product->decrement('stock', 1);
        }

        return response()->json([
            'message' => 'Compra realizada exitosamente',
            'status' => 'success'
        ], 200);
    }
}