<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\OrderStatusUpdated;
use App\Listeners\NotifyUserAboutOrderStatus;

class EventServiceProvider extends ServiceProvider
{
    

    protected $listen = [
        OrderStatusUpdated::class => [
            NotifyUserAboutOrderStatus::class,
        ],
    ];


    public function boot(): void
    {
        parent::boot();
    }
}
