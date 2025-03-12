<?php

namespace App\Http\Controllers;

use App\Events\OrderStatusUpdated;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
//use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Controllers\CartController;
use App\Models\ShoppingCart;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderCollection;
//use App\Jobs\UpdateOrderStatus; // Импортируем Job этого не было 
//use Carbon\Carbon; /// этого не было 

use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index()
    {
       // dd(1);
        $orders = Order::with('user')->get();
       return new OrderCollection($orders); // Используем OrderCollection
     
       //return Order::with('user')->get();
    }

    public function store(StoreOrderRequest  $request)
    {
        $userId = $request->input('user_id'); // Получаем user_id из запроса
        $user = User::find($userId); // Находим пользователя по ID
    
        if (!$user) {
            return response()->json(['error' => 'Пользователь не найден'], 404);
        }
    
        $cartItems = ShoppingCart::with('product')->where('user_id', $user->id)->get();
    
        if ($cartItems->isEmpty()) {
            return response()->json(['error' => 'Корзина пуста'], 400);
        }
    
        
        DB::beginTransaction();
    
        try {
            // Проверяем наличие товаров на складе
            foreach ($cartItems as $cartItem) {
                if ($cartItem->product->stock < $cartItem->quantity) {
                    throw new \Exception("Недостаточно товара: {$cartItem->product->name}");
                }
            }
    
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
            
            // Очищаем корзину
            $user->ShoppingCarts()->delete();
    
            DB::commit();
            
           
            // Запускаем Job с задержкой в 1 минуту (или 24 часа, как у вас в Job)
            //UpdateOrderStatus::dispatch($order)->delay(now()->addMinutes(1)); // Или addHours(24)


            return new OrderResource($order); // Используем OrderResource
            //return response()->json(['message' => 'Заказ успешно оформлен'], 201);
    
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    
    }

    public function show($id)
    {
        $order = Order::with('user', 'products')->findOrFail($id);
        return new OrderResource($order); // Используем OrderResource
        //return response()->json($order);
    }

    public function update(UpdateOrderRequest  $request, $id)
    {

      $order = Order::findOrFail($id);

         // Сохраняем старый статус заказа
        $oldStatus = $order->status;
        
// Обновляем статус заказа, если он передан в запросе
//dd($request->status);
        if ($request->has('status')) {
            $order->status = $request->status;
        }

         // Обновляем продукты в заказе, если они переданы в запросе
        if ($request->has('products')) {
            // Ниже Обработка обновления продуктов в заказе и логика для обновления количества

            $products = $request->input('products'); 

             foreach ($products as $productData) {
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
        

        // Проверяем, изменился ли статус заказа
        if ($request->has('status') && $oldStatus !== $order->status) {
        // Вызываем событие, передавая заказ
        event(new OrderStatusUpdated($order));
        }

    /*    $user=User::latest()->first();
        Mail::raw("Статус вашего заказа  изменен на", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Статус вашего заказа изменен');
        });*/

// Возвращаем обновленный заказ с использованием OrderResource
        return new OrderResource($order);  

        //return response()->json($order);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json(null, 204);
    }


        // Метод для получения деталей заказа
    public function getOrderDetails($id) 
    {
        $order = Order::with('products')->findOrFail($id); // Предполагается, что у заказа есть связь с продуктами
        return new OrderResource($order); // Используем OrderResource
        //return response()->json($order);
    }
}


