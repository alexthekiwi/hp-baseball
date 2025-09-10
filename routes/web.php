<?php

use Illuminate\Support\Facades\Route;

Route::statamic('help', 'docs/index', [
    'title' => 'Example',
])->middleware(['auth']);

Route::redirect('/login', '/admin', 302)->name('login');
