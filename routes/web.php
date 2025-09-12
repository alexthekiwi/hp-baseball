<?php

use Illuminate\Support\Facades\Route;

Route::statamic('help', 'docs/index', [
    'title' => 'Example',
])->middleware(['auth']);

Route::redirect('/login', '/admin', 302)->name('login');

Route::statamic('checkout', 'checkout.index', ['title' => 'Checkout', 'layout' => 'checkout.layout'])->name('checkout');
Route::statamic('checkout/confirmation', 'checkout.confirmation', ['title' => 'Order Confirmation', 'layout' => 'checkout.layout'])
    ->name('checkout.confirmation')
    ->middleware('signed');
