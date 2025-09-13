<?php

namespace App\Providers;

use App\Mail\OrderConfirmation;
use App\Mail\OrderNotification;
use DuncanMcClean\Cargo\Events\OrderPaymentReceived;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;
use Statamic\Statamic;

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
        Event::listen(OrderPaymentReceived::class, function ($event) {
            Mail::to($event->order->customer())
                ->locale($event->order->site()->shortLocale())
                ->send(new OrderConfirmation($event->order));

            Mail::to(config('mail.to.admin'))
                ->locale($event->order->site()->shortLocale())
                ->send(new OrderNotification($event->order));
        });

        // Statamic::vite('app', [
        //     'resources/js/cp.js',
        //     'resources/css/cp.css',
        // ]);
    }
}
