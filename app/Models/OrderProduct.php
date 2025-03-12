<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderProduct extends Pivot
{
    // добавить дополнительные методы или свойства
    // Связь с моделью Order
   /* public function order()
    {
        return $this->belongsTo(Order::class);
    }*/

    // Связь с моделью Product
    /*public function product()
    {
        return $this->belongsTo(Product::class);
    }*/
}

