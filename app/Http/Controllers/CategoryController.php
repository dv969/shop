<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductCollection;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(): JsonResponse
    {
        $categories = $this->categoryService->getAllCategories();
        return (new CategoryCollection($categories))->response(); // Используем CategoryCollection
    }

    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = $this->categoryService->createCategory($request->validated());
        return (new CategoryResource($category))->response()->setStatusCode(201);
    }

    public function show($id): JsonResponse
    {
        $category = $this->categoryService->getCategoryById($id);
        return (new CategoryResource($category))->response();
    }

    public function update(UpdateCategoryRequest $request, $id): JsonResponse
    {
        $category = $this->categoryService->updateCategory($id, $request->validated());
        return (new CategoryResource($category))->response()->setStatusCode(200);
    }

    public function destroy($id): JsonResponse
    {
        $this->categoryService->deleteCategory($id);
        return response()->json(null, 204);
    }

    public function getCategoryProducts($id): JsonResponse
    {
        $products = $this->categoryService->getCategoryProducts($id);
        return (new ProductCollection($products))->response(); // Используем ProductCollection
    }
}
