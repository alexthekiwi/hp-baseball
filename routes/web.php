<?php

use App\Mail\OrderConfirmation;
use App\Mail\OrderNotification;
use DuncanMcClean\Cargo\Facades\Order;
use Illuminate\Support\Facades\Route;

Route::statamic('help', 'docs/index', [
    'title' => 'Example',
])->middleware(['auth']);

Route::redirect('/login', '/admin', 302)->name('login');

Route::statamic('checkout', 'checkout.index', ['title' => 'Checkout', 'layout' => 'checkout.layout'])->name('checkout');
Route::statamic('checkout/confirmation', 'checkout.confirmation', ['title' => 'Order Confirmation', 'layout' => 'checkout.layout'])
    ->name('checkout.confirmation')
    ->middleware('signed');

if (app()->environment('local')) {
    Route::get('/order-confirmation', function () {
        $order = request()->input('id')
            ? Order::query()->findOrFail(request()->input('id'))
            : Order::query()->orderByDesc('date')->first();

        return new OrderConfirmation($order);
    });

    Route::get('/order-notification', function () {
        $order = request()->input('id')
            ? Order::query()->findOrFail(request()->input('id'))
            : Order::query()->orderByDesc('date')->first();

        return new OrderNotification($order);
    });
}
