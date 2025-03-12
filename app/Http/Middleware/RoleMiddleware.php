<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role = null): Response
    {
    

             // Отладка: выводим текущего аутентифицированного пользователя
            //dd($request->role);
    
            // Проверка роли пользователя
            if ($request->role == 'customer') {
                return response()->json(['message' => 'Forbidden'], 403);
            }


        return $next($request);
    }
}
     

            /* 
              1 варинат      if (!Auth::check() || !Auth::user()->hasRole($role)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }


        на это отвечает 
            if (!Auth::check() || !Auth::user()->hasRole($role)) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }


самый первай вариант
         // Проверяем, авторизован ли пользователь
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = Auth::user(); 
        if (!$user instanceof \App\Models\User) {
            return response()->json(['message' => 'Invalid user object'], 500);
        }


        // Проверяем, имеет ли пользователь нужную роль
        if (!Auth::user()->hasRole($role)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }*/