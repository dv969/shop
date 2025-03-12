<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\CartController;



    // I. ***!!!!!!МАРШРУТЫ ДЛЯ АДМИНИСТРАТОРОВ!!!!!!***
    Route::post('/users', [UserController::class, 'store']); // Создать нового пользователя
    Route::get('/users', [UserController::class, 'index']); // Получить список пользователей
    Route::get('/users/{id}', [UserController::class, 'show']); // Получить информацию о пользователе
    Route::put('/users/{id}', [UserController::class, 'update']); // Обновить информацию о пользователе
    Route::delete('/users/{id}', [UserController::class, 'destroy']); // Удалить пользователя

    // Категории
    Route::get('/categories', [CategoryController::class, 'index']); // Получить список категорий
    Route::post('/categories', [CategoryController::class, 'store']); // Создать новую категорию
    Route::get('/categories/{id}', [CategoryController::class, 'show']); // Получить информацию о категории
    Route::put('/categories/{id}', [CategoryController::class, 'update']); // Обновить информацию о категории
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']); // Удалить категорию

    // Продукты
    Route::get('/products', [ProductController::class, 'index']); // Получить список продуктов
    Route::post('/products', [ProductController::class, 'store']); // Создать новый продукт
    Route::get('/products/{id}', [ProductController::class, 'show']); // Получить информацию о продукте
    Route::put('/products/{id}', [ProductController::class, 'update']); // Обновить информацию о продукте
    Route::delete('/products/{id}', [ProductController::class, 'destroy']); // Удалить продукт
    

    
    // II. ***!!!!!!СТАНДАРТНЫЕ МАРШРУТЫ для ЗАКАЗОВ (ДОСТУПНЫ ВСЕМ)!!!!!!***
    Route::get('/orders', [OrderController::class, 'index']); // Получить список заказов
    Route::post('/orders', [OrderController::class, 'store']); // Создать новый заказ
    Route::get('/orders/{id}', [OrderController::class, 'show']); // Получить информацию о заказе
    Route::put('/orders/{id}', [OrderController::class, 'update']); // Обновить информацию о заказе
    Route::delete('/orders/{id}', [OrderController::class, 'destroy']); // Удалить заказ
    

    // III. ***!!!!!!МАРШРУТЫ ДЛЯ ПОКУПАТЕЛЕЙ!!!!!!***
  //  Route::get('ClientsCategories', [CategoryController::class, 'index']); // Получение списка категорий
   // Route::get('ClientsOrders', [OrderController::class, 'getUserOrders']); // Получение заказов пользователя   Получение информации о заказах пользователя



    // IV. ***!!!!!!МАРШРУТЫ ДЛЯ УПРАВЛЕНИЯ КОРЗИНОЙ!!!!!!***
    Route::post('/cart/add', [CartController::class, 'addToCart']);
    Route::delete('/cart/remove', [CartController::class, 'removeFromCart']);
    Route::get('/cart', [CartController::class, 'getCart']);
    










 /* Route::middleware('auth:api')->group(function () {
    
    // Маршруты для администраторов
  Route::middleware('role:admin')->group(function () {
        // Пользователи
        Route::get('users', [UserController::class, 'index']); // Получить список пользователей
        Route::post('users', [UserController::class, 'store']); // Создать нового пользователя
        Route::get('users/{id}', [UserController::class, 'show']); // Получить информацию о пользователе
        Route::put('users/{id}', [UserController::class, 'update']); // Обновить информацию о пользователе
        Route::delete('users/{id}', [UserController::class, 'destroy']); // Удалить пользователя

        // Категории
        Route::get('categories', [CategoryController::class, 'index']); // Получить список категорий
        Route::post('categories', [CategoryController::class, 'store']); // Создать новую категорию
        Route::get('categories/{id}', [CategoryController::class, 'show']); // Получить информацию о категории
        Route::put('categories/{id}', [CategoryController::class, 'update']); // Обновить информацию о категории
        Route::delete('categories/{id}', [CategoryController::class, 'destroy']); // Удалить категорию

        // Продукты
        Route::get('products', [ProductController::class, 'index']); // Получить список продуктов
        Route::post('products', [ProductController::class, 'store']); // Создать новый продукт
        Route::get('products/{id}', [ProductController::class, 'show']); // Получить информацию о продукте
        Route::put('products/{id}', [ProductController::class, 'update']); // Обновить информацию о продукте
        Route::delete('products/{id}', [ProductController::class, 'destroy']); // Удалить продукт
    });

    // Стандартные маршруты для заказов (доступны всем)
    Route::get('orders', [OrderController::class, 'index']); // Получить список заказов
    Route::post('orders', [OrderController::class, 'store']); // Создать новый заказ
    Route::get('orders/{id}', [OrderController::class, 'show']); // Получить информацию о заказе
    Route::put('orders/{id}', [OrderController::class, 'update']); // Обновить информацию о заказе
    Route::delete('orders/{id}', [OrderController::class, 'destroy']); // Удалить заказ

    // Маршруты для покупателей
    Route::middleware('role:customer')->group(function () {
        // Получение списка категорий
        Route::get('categories', [CategoryController::class, 'index']); // Получение списка категорий
        // Получение информации о заказах пользователя
        Route::get('orders', [OrderController::class, 'getUserOrders']); // Получение заказов пользователя
    });
});

*/




/*
Route::middleware('auth:api')->group(function () {
    
    // Стандартные маршруты для пользователей
    Route::apiResource('users', UserController::class);
    // Нестандартный маршрут для
    Route::get('users/{id}/orders', [UserController::class, 'getUserOrders']);


    // Стандартные маршруты для категорий
    Route::apiResource('categories', CategoryController::class);
   // Нестандартный маршрут для
    Route::get('categories/{id}/products', [CategoryController::class, 'getCategoryProducts']);


    // Стандартные маршруты для ПРОДУКТОВ
    Route::apiResource('products', ProductController::class);
    // Нестандартный маршрут для получения продуктов по категории
    Route::get('products/category/{categoryId}', [ProductController::class, 'getProductsByCategory']);
    // Нестандартный маршрут для поиска продуктов
    Route::get('products/search', [ProductController::class, 'searchProducts']);


    // Стандартные маршруты для заказов
    Route::apiResource('orders', OrderController::class);
 //Нестандартный маршрут для получения заказов пользователя
    Route::get('orders/{id}/details', [OrderController::class, 'getOrderDetails']);


});*/