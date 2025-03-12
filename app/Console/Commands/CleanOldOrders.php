<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Carbon\Carbon;
use App\Jobs\UpdateOrderStatus;

class CleanOldOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Удаляет заказы со статусом "canceled", созданные более 30 дней назад';

    /**
     * Execute the console command.
     */
    
    public function handle()
    {
        $date = Carbon::now()->subDays(30); // Дата 30 дней назад
        $deleted = Order::where('status', 'canceled')
            ->where('created_at', '<', $date)
            ->delete();
            $order = Order::find(3);
          

        $this->info("Удалено {$deleted} старых заказов.");
    }
}

