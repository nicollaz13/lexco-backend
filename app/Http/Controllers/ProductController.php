<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;


class ProductController extends Controller
{
/**
 * Realizar la compra de un producto y descontar stock.
 * 
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\JsonResponse
 * @author Nicolas hernandez
 * @since 2024/05
 */
    public function index()
    {
        //trae todo de la tabla
        $products = Product::all();
        return response()->json(['products' => $products], 200);
    }

/**
 * Almacena un nuevo registro.
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\Http\JsonResponse
 */
    public function store(Request $request)
    {
        // revisa la cantidad de productos
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|',
            'description' => 'nullable|string|',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);
         // registrar el producto en la base de datos
            $product = \App\Models\Product::create($request->all());
        // respuesta
        return response()->json([
            'message' => 'Producto registrado exitosamente',
            'product' => $product], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $product = Product::findOrFail($id);
         return response()->json(['product' => $product], 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {


        // El Buscador por su ID
        $product = Product::findOrFail($id);

        // El "Cambio": Tomamos la nueva información y sobreescribimos la vieja
        $product->update($request->all());

        // La "Confirmación": Le decimos a Postman que todo salió bien
        return response()->json([
            'message' => '¡Producto actualizado con éxito!',
            'data' => $product
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function edit(string $id){

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //se busca el producto por id
        $product = \App\Models\Product::find($id);
        // si no existe el producto, se devuelve un error
        if(!$product){
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }
        //si existe se elimina el producto1.
        $product->delete();
        return response()->json(['message' => 'Producto eliminado exitosamente'], 200);
    }


public function purchase(Request $request){

    //validad entrada
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
    ]);

    $product = \App\Models\Product::find($request->product_id);

    //si no hay suficiente stock, se devuelve un error
    if($product->stock < $request->quantity){
        return response()->json(['message' => 'Stock insuficiente'], 400);
    }
    //descontar el stock
    $product->stock -= $request->quantity;
    $product->save();

    return response()->json(['message' => 'Compra realizada exitosamente',
                             'data' =>[
                                'product_id' => $product->id,
                                'quantity' => $request->quantity,
                                'new_stock' => $product->stock
                             ]
                            ], 200);

}
}


