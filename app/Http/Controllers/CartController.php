<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartAddtoCartRequest;
use App\Http\Requests\CartGetCartRequest;
use App\Http\Requests\CartremoveFromCartRequest;
use App\Http\Resources\ShoppingCartCollection;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function addToCart(CartAddtoCartRequest $request): JsonResponse
    {
        try {
            $this->cartService->addToCart($request->input('user_id'), $request->input('product_id'), $request->input('quantity'));
            return response()->json(['message' => 'Товар добавлен в корзину'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function removeFromCart(CartremoveFromCartRequest $request): JsonResponse
    {
        $this->cartService->removeFromCart($request->input('user_id'), $request->input('product_id'));
        return response()->json(['message' => 'Товар удален из корзины'], 200);
    }

    public function getCart(CartGetCartRequest $request): JsonResponse
    {
        $cartItems = $this->cartService->getCart($request->input('user_id'));
        return new ShoppingCartCollection($cartItems); // Используем ShoppingCartCollection
    }
}
