<?php

namespace App\Events;


use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order; // этого не было 

class OrderStatusUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


     public $order; //// этого не было 

    public function __construct(Order $order) ///тут в скобках было пусто сейчас появились (Order $order)
    {
        
        $this->order = $order;
    }


}


