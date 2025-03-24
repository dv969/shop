<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ShoppingCart;

class CartService
{
    public function addToCart($userId, $productId, $quantity)
    {
        $product = Product::find($productId);
        if (!$product) {
            throw new \Exception('Товар не найден');
        }

        $cartItem = ShoppingCart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            ShoppingCart::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }
    }

    public function removeFromCart($userId, $productId)
    {
        ShoppingCart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->delete();
    }

    public function getCart($userId)
    {
        return ShoppingCart::with('product')->where('user_id', $userId)->get();
    }
}
