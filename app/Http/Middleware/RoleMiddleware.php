<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, string $role = null): Response
    {

        if (Auth::check() && Auth::user()->role == 'customer') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // Проверка роли пользователя
        /* if ($request->role == 'customer') {
               return response()->json(['message' => 'Forbidden'], 403);
           }*/


        return $next($request);

    }
}
