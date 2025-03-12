<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
// всего что ниже не было 
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;
use App\Events\OrderStatusUpdated;
use Carbon\Carbon;


class UpdateOrderStatus implements ShouldQueue // implements ShouldQueue тоже не было 
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels; // было use Queueable;

    /**
     * Create a new job instance.
     */

     protected $order; // не было 
    public function __construct(Order $order) // в скобках было пусто 
    {
        $this->order = $order;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
       
      /*  if ($this->order->status === 'pending' && $this->order->created_at->diffInHours(Carbon::now()) >= 1) {
            $this->order->status = 'canceled';
            $this->order->save();*/

            // Отправляем событие
            event(new OrderStatusUpdated($this->order));
    //  }
    }
}
