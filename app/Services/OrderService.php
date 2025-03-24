<?php

namespace App\Services;

use App\Models\Order;
use App\Models\ShoppingCart;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Events\OrderStatusUpdated;  // Импортируем событие

class OrderService
{
    public function getAllOrders()
    {
        return Order::with('user')->get();
    }


    public function store($userId)
    {
        $user = User::find($userId);

        $cartItems = ShoppingCart::with('product')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            throw new \Exception('Корзина пуста');
        }

        DB::beginTransaction();

        try {
            // Проверяем наличие товаров на складе
            foreach ($cartItems as $cartItem) {
                if ($cartItem->product->stock < $cartItem->quantity) {
                    throw new \Exception("Недостаточно товара: {$cartItem->product->name}");
                }
            }

            $order = $this->addProductsToCart($cartItems, $user);

            // Очищаем корзину
            $user->ShoppingCarts()->delete();

            DB::commit();

            return $order;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e; // Пробрасываем исключение дальше
        }
    }

    private function addProductsToCart($cartItems, User $user): Order
    {
        // Создаем заказ
        $order = Order::create([
            'user_id' => $user->id,
            'status' => 'pending',
            'total_price' => 0,
        ]);

        // Добавляем товары в заказ
        foreach ($cartItems as $cartItem) {
            $order->products()->attach($cartItem->product_id, [
                'quantity' => $cartItem->quantity,
            ]);

            // Уменьшаем количество товара на складе
            $cartItem->product->stock -= $cartItem->quantity;
            $cartItem->product->save();

            // Обновляем общую цену заказа
            $order->total_price += $cartItem->product->price * $cartItem->quantity;
        }

        // Сохраняем обновленную цену заказа
        $order->save();

        return $order;

    }

    public function getOrderById($id)
    {
        return Order::with('user', 'products')->findOrFail($id);
    }

    public function updateOrder($id, array $data)
    {
        $order = Order::findOrFail($id);

        if (isset($data['status'])) {
            $oldStatus = $order->status; // Сохраняем старый статус
            $order->status = $data['status']; // Обновляем статус
            $order->save();

            // Вызываем событие, если статус изменился
            if ($oldStatus !== $order->status) {
                event(new OrderStatusUpdated($order)); // Используем событие
            }
        }

        if (isset($data['products'])) {
            foreach ($data['products'] as $productData) {
                $productId = $productData['id'];
                $quantity = $productData['quantity'];

                $product = $order->products()->find($productId);

                if ($product) {
                    $product->pivot->quantity = $quantity;
                    $product->pivot->save();
                } else {
                    $order->products()->attach($productId, ['quantity' => $quantity]);
                }
            }
        }

        $order->save();
        return $order;
    }

    public function deleteOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
    }

    public function getOrderDetails($id)
    {
        return Order::with('products')->findOrFail($id);
    }

}
