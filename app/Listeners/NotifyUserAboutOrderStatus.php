<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\OrderStatusUpdated;
use App\Mail\OrderStatusChangedMail;
use Illuminate\Support\Facades\Log; // Импортируем класс Log не было 

use Illuminate\Support\Facades\Mail;


class NotifyUserAboutOrderStatus implements ShouldQueue  // implements ShouldQueue не было 
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderStatusUpdated $event): void
    {

        $order = $event->order;
        $user = $order->user;
        


        // Отправка уведомления на email (без использования view)
     /*   Mail::raw("Статус вашего заказа #{$order->id} изменен на {$order->status}.", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Статус вашего заказа изменен');
        });*/

        // Отправка уведомления на email
      
       Mail::to($user->email)->send(new OrderStatusChangedMail($order));

        // Логирование для примера
        Log::info("Статус заказа #{$order->id} изменен на 'canceled'. Пользователь: {$user->email}");

    }
}