<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryCollection;

class CategoryController extends Controller
{
    public function index()
    {
        
        //return Category::all(); // Возвращает все категории из базы данных.
        $categories = Category::all();
       
        //return CategoryResource::collection($categories); // НЕ РАБОТАЕТ
       //return response()->json($categories); // !!!!РАБОТАЕТ!!!!!
        return new CategoryCollection($categories); // Используем CategoryCollection НЕ РАБОТАЕТ
    }

    public function show($id)
    {
       // return Category::findOrFail($id); // Возвращает категорию по ID или 404, если не найдено.
       $category = Category::findOrFail($id);
        return new CategoryResource($category); // Используем CategoryResource

    }

    public function store(StoreCategoryRequest  $request)
    {

        $category = Category::create($request->validated()); // Создает новую категорию с данными из запроса, прошедшими валидацию.
      
        return new CategoryResource($category); // Используем CategoryResource
    }

    public function update(UpdateCategoryRequest  $request, $id)
    {
        $category = Category::findOrFail($id);


        $category->update($request->only(['name', 'slug'])); // Обновляет данные категории.
        return new CategoryResource($category); // Используем CategoryResource
       // return response()->json($category, 200); // Возвращает обновленную категорию.
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete(); // Удаляет категорию.
        return response()->json(null, 204); // Возвращает статус 204 No Content.
    }

        // Метод для получения продуктов по категории
    public function getCategoryProducts($id)
    {
        $category = Category::findOrFail($id);
        $products = $category->products; // Предполагается, что у категории есть связь с продуктами
        return new CategoryResource($category); // Используем CategoryResource
      //  return response()->json($products);
    }
}
