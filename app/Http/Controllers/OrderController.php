<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(): JsonResponse
    {
        $orders = $this->orderService->getAllOrders();
        return (new OrderCollection($orders))->response(); // Используем OrderCollection
    }


    public function store(StoreOrderRequest $request): JsonResponse|OrderResource
    {
        try {

            $order = $this->orderService->store($request->input('user_id'));
            return new OrderResource($order);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show($id): JsonResponse
    {
        $order = $this->orderService->getOrderById($id);
        return (new OrderResource($order))->response();
    }


    public function update(UpdateOrderRequest $request, $id): JsonResponse
    {
        $order = $this->orderService->updateOrder($id, $request->validated());
        return (new OrderResource($order))->response();
    }


    public function destroy($id): JsonResponse
    {
        $this->orderService->deleteOrder($id);
        return response()->json(null, 204);
    }


    // Метод для получения деталей заказа
    public function getOrderDetails($id): JsonResponse
    {
        $order = $this->orderService->getOrderDetails($id);
        return (new OrderResource($order))->response();
    }

}


