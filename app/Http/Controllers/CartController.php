<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShoppingCart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CartAddtoCartRequest;
use App\Http\Requests\CartremoveFromCartRequest;
use App\Http\Requests\CartGetCartRequest;
use App\Http\Resources\ShoppingCartResource;
use App\Http\Resources\ShoppingCartCollection;


class CartController extends Controller
{
    // Добавление товара в корзину
    public function addToCart(CartAddtoCartRequest $request)
    {
        
        // Получаем product_id из запроса
        $product = Product::find($request->product_id);
        if (!$product) {
            return response()->json(['error' => 'Товар не найден'], 404);
        }
    
        // Здесь предполагается, что user_id передается в запросе
        $userId = $request->input('user_id'); // Получаем user_id из запроса
    
        // Проверяем, есть ли товар уже в корзине
        $cartItem = ShoppingCart::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->first();
    
        if ($cartItem) {
            // Если товар уже в корзине, увеличиваем количество
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            // Если товара нет в корзине, создаем новую запись
            ShoppingCart::create([
                'user_id' => $userId,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);
        }
    
        return response()->json(['message' => 'Товар добавлен в корзину'], 201);
    }

    // Удаление товара из корзины
    public function removeFromCart(CartremoveFromCartRequest $request)
    {
    
        // Получаем user_id из запроса
        $userId = $request->input('user_id');
    
        ShoppingCart::where('user_id', $userId)
            ->where('product_id', $request->product_id)
            ->delete();
    
        return response()->json(['message' => 'Товар удален из корзины'], 200);
    }

    // Получение содержимого корзины
    public function getCart(CartGetCartRequest $request)
    {
    
        // Получаем user_id из запроса
        $userId = $request->input('user_id');
    
        $cartItems = ShoppingCart::with('product')->where('user_id', $userId)->get();
    
        return new ShoppingCartCollection($cartItems); // Используем ShoppingCartCollection
        //return response()->json($cartItems, 200);
    }

}






