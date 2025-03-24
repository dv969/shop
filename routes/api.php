<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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


//***!!!!!!МАРШРУТЫ ДЛЯ УПРАВЛЕНИЯ КОРЗИНОЙ!!!!!!***
Route::post('/cart/add', [CartController::class, 'addToCart']);
Route::delete('/cart/remove', [CartController::class, 'removeFromCart']);
Route::get('/cart', [CartController::class, 'getCart']);

// Маршруты для покупателей
Route::middleware('role:customer')->group(function () {
    // Получение списка категорий
    Route::get('ClientsCategories', [CategoryController::class, 'index']); // Получение списка категорий
    // Получение информации о заказах пользователя
    Route::get('ClientsOrders', [OrderController::class, 'getUserOrders']); // Получение заказов пользователя
});


/*
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
   // Route::get('ClientsCategories', [CategoryController::class, 'index']); // Получение списка категорий
    //Route::get('ClientsOrders', [OrderController::class, 'getUserOrders']); // Получение заказов пользователя   Получение информации о заказах пользователя



    // IV. ***!!!!!!МАРШРУТЫ ДЛЯ УПРАВЛЕНИЯ КОРЗИНОЙ!!!!!!***
    Route::post('/cart/add', [CartController::class, 'addToCart']);
    Route::delete('/cart/remove', [CartController::class, 'removeFromCart']);
    Route::get('/cart', [CartController::class, 'getCart']);
*/










