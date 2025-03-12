<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Events\OrderStatusUpdated;
use App\Listeners\NotifyUserAboutOrderStatus;
use Illuminate\Support\Facades\Event; // Импортируем класс Event


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
    }
}
