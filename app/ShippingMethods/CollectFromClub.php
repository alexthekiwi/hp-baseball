<?php

namespace App\ShippingMethods;

use DuncanMcClean\Cargo\Contracts\Cart\Cart;
use DuncanMcClean\Cargo\Shipping\ShippingMethod;
use DuncanMcClean\Cargo\Shipping\ShippingOption;
use Illuminate\Support\Collection;

class CollectFromClub extends ShippingMethod
{
    public function options(Cart $cart): Collection
    {
        return collect([
            ShippingOption::make($this)
                ->name(__('Collect from Club'))
                ->price(0),
        ]);
    }

    // public function fieldtypeDetails(Order $order): array
    // {
    //     return [
    //         __('Available from') => now()->parse('2025-10-01')->format('d M y'),
    //     ];
    // }
}
