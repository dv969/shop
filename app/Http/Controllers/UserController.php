<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;




class UserController extends Controller
{
    public function index()
    {
        $users = User::all(); // Возвращает всех пользователей из базы данных.
        return new UserCollection($users); // Используем UserCollection
    }

    public function store(UserRequest $request)
    {
        
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password); // Хеширует пароль перед сохранением.
        $user->role = $request->role; // СТАЛО ЭТО Устанавлвает роль пользователя из запроса
        // $user->role = 'customer'; //     БЫЛО ЭТО Устанавливает роль пользователя.
        $user->save(); // Сохраняет пользователя в базе данных.


        return new UserResource($user); // !!СТАЛО!!

        //!!БЫЛО!! return response()->json($user, 201); // Возвращает созданного пользователя с кодом 201.
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update($request->only(['name', 'email', 'password'])); // Обновляет данные пользователя.
        return new UserResource($user); // Используем UserResource

       // return response()->json($user, 200); // Возвращает обновленного пользователя.
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete(); // Удаляет пользователя.
        return response()->json(null, 204); // Возвращает статус 204 No Content.
    }

    public function show($id)
    {
      $user = User::with('orders')->findOrFail($id); // Загружает пользователя и его заказы
      
      return new UserResource($user); // Используем UserResource
      //return response()->json($user); // Возвращает пользователя с его заказами
    }

        // Метод для получения заказов пользователя
    public function getUserOrders($id)
    {
        $user = User::findOrFail($id);
        $orders = $user->orders; // Предполагается, что у пользователя есть связь с заказами
        
        return new UserResource($user); // Используем UserResource
        //return response()->json($orders);
    }

}

