<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;

class ProductController extends Controller
{
    public function index()
    {
        //return Product::with('category')->where('stock', '>', 0)->get();

        $products = Product::with('category')->where('stock', '>', 0)->get();
        return new ProductCollection($products); // Используем ProductCollection
    }

    public function store(ProductStoreRequest $request)
    {

        $product = Product::create($request->validated());// Используем $request->validated() для получения валидированных данных
        // return response()->json($product, 201);
        return new ProductResource($product); // Используем ProductResource
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return new ProductResource($product); // Используем ProductResource
        
        //return response()->json($product);
    }

    public function update(ProductUpdateRequest $request, $id)
    {

        $product = Product::findOrFail($id);
        $product->update($request->validated()); // Используйте $request->validated() для получения валидированных данных
        return new ProductResource($product); // Используем ProductResource
        //return response()->json($product);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(null, 204);
    }

      // Метод для получения продуктов по категории
      public function getProductsByCategory($categoryId)
      {
          $products = Product::where('category_id', $categoryId)->get();
          return new ProductCollection($products); // Используем ProductCollection

          //return response()->json($products);
      }

      // Метод для поиска продуктов
    public function searchProducts(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'LIKE', "%{$query}%")->get();
        return new ProductCollection($products); // Используем ProductCollection

       // return response()->json($products);
    }
}





