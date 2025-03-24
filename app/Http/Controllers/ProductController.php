<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(): JsonResponse
    {
        $products = $this->productService->getAllProducts();
        return (new ProductCollection($products))->response(); // Используем ProductCollection
    }

    public function store(ProductStoreRequest $request): JsonResponse
    {
        $product = $this->productService->createProduct($request->validated());
        return (new ProductResource($product))->response()->setStatusCode(201);
    }

    public function show($id): JsonResponse
    {
        $product = $this->productService->getProductById($id);
        return (new ProductResource($product))->response();
    }

    public function update(ProductUpdateRequest $request, $id): JsonResponse
    {
        $product = $this->productService->updateProduct($id, $request->validated());
        return (new ProductResource($product))->response();
    }

    public function destroy($id): JsonResponse
    {
        $this->productService->deleteProduct($id);
        return response()->json(null, 204);
    }

    public function getProductsByCategory($categoryId): JsonResponse
    {
        $products = $this->productService->getProductsByCategory($categoryId);
        return (new ProductCollection($products))->response(); // Используем ProductCollection
    }

    public function searchProducts(Request $request): JsonResponse
    {
        $query = $request->input('query');
        $products = $this->productService->searchProducts($query);
        return (new ProductCollection($products))->response(); // Используем ProductCollection
    }
}
