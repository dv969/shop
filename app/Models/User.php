<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Database\Eloquent\Model;

class User extends Model //Authenticatable
{

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
    
        // Связь с корзиной
    public function ShoppingCarts()
    {
        return $this->hasMany(ShoppingCart::class);
    }
    
}


