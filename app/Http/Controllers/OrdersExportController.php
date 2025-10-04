<?php

namespace App\Http\Controllers;

use DuncanMcClean\Cargo\Facades\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class OrdersExportController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(
            ['date_from' => ['required', 'date_format:Y-m-d', 'before_or_equal:today']],
        );

        // Get the orders to export
        $orders = Order::query()
            ->where('date', '>', $request->input('date_from'))
            ->get();

        if ($orders->isEmpty()) {
            $request->session()->flash('error', 'No orders in this range. Try an earlier date.');

            return to_route('statamic.cp.dashboard');
        }

        Artisan::call('app:export-orders', [
            '--output' => 'email',
            '--since' => $request->input('date_from'),
        ]);

        $request->session()->flash('success', 'Export successful! Check your emails.');

        return to_route('statamic.cp.dashboard');
    }
}
