<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(): JsonResponse
    {
        $users = $this->userService->getAllUsers();
        return (new UserCollection($users))->response(); // Используем UserCollection
    }

    public function store(UserRequest $request): JsonResponse
    {
        $user = $this->userService->createUser($request->validated());
        return (new UserResource($user))->response()->setStatusCode(201);
    }

    public function update(UserUpdateRequest $request, $id): JsonResponse
    {
        $user = $this->userService->updateUser($id, $request->validated());
        return (new UserResource($user))->response()->setStatusCode(200);
    }

    public function destroy($id): JsonResponse
    {
        $this->userService->deleteUser($id);
        return response()->json(null, 204);
    }

    public function show($id): JsonResponse
    {
        $user = $this->userService->getUserWithOrders($id);
        return (new UserResource($user))->response();
    }

    public function getUserOrders($id): JsonResponse
    {
        $orders = $this->userService->getUserOrders($id);
        return OrderResource::collection($orders)->response();
    }
}
