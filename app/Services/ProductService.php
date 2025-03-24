<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function getAllProducts()
    {
        return Product::with('category')->where('stock', '>', 0)->get();
    }

    public function createProduct(array $data)
    {
        return Product::create($data);
    }

    public function getProductById($id)
    {
        return Product::with('category')->findOrFail($id);
    }

    public function updateProduct($id, array $data)
    {
        $product = Product::findOrFail($id);
        $product->update($data);
        return $product;
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
    }

    public function getProductsByCategory($categoryId)
    {
        return Product::where('category_id', $categoryId)->get();
    }

    public function searchProducts($query)
    {
        return Product::where('name', 'LIKE', "%{$query}%")->get();
    }
}
