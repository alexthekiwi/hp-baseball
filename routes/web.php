<?php

use App\Http\Controllers\OrdersExportController;
use App\Http\Controllers\XmlSitemapController;
use App\Mail\OrderConfirmation;
use App\Mail\OrderNotification;
use DuncanMcClean\Cargo\Facades\Order;
use Illuminate\Support\Facades\Route;

Route::statamic('help', 'docs/index', [
    'title' => 'Example',
])->middleware(['auth']);

Route::post('/orders-export', [OrdersExportController::class, 'store'])
    ->middleware(['auth'])
    ->name('orders-export.store');

Route::redirect('/login', '/admin', 302)->name('login');

Route::statamic('checkout', 'checkout.index', ['title' => 'Checkout', 'layout' => 'checkout.layout'])->name('checkout');
Route::statamic('checkout/confirmation', 'checkout.confirmation', ['title' => 'Order Confirmation', 'layout' => 'checkout.layout'])
    ->name('checkout.confirmation')
    ->middleware('signed');

Route::get('/sitemap.xml', [XmlSitemapController::class, 'index'])->name('sitemap.xml');

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
