<x-mail::message>
# Order #{{ $order->orderNumber }} has been confirmed

A new online order has been made. Please notify the customer when this order is ready for collection.

<x-mail::button url="{{  url('/admin/orders/' . $order->id) . '/edit' }}" color="primary">
View Order Online
</x-mail::button>

<x-mail::table>
| Item Description   |               |
| :----------------- | ------------: |
@foreach($order->lineItems() as $lineItem)
@php
$hasDownloads = $lineItem->hasDownloads();
$downloadUrl = URL::signedRoute('statamic.cargo.download', [
    'orderId' => $order->id(),
    'lineItem' => $lineItem->id(),
]);
@endphp
| {{ $lineItem->quantity }}x {{ $lineItem->product()->title }} - {{  $lineItem->variant()?->name }} | {{ $lineItem->sub_total }} |
@endforeach
</x-mail::table>

<x-mail::table>
|                    |               |
| -----------------: | ------------: |
| **Subtotal** | {{ $order->sub_total }} |
@if($order->discounts)
| **Discounts** | -{{ $order->discount_total }}|
@endif
@if($order->shippingOption)
| **Shipping** ({{ $order->shippingOption()->name }}) | {{ $order->shipping_total }} |
@endif
@unless(config('statamic.cargo.taxes.price_includes_tax'))
| **Taxes** | {{ $order->tax_total }} |
@endunless
| **Total** | **{{ $order->grand_total }}** |
</x-mail::table>

<x-mail::panel>
@if($order->shippingOption)
**Shipping Option:** {{ $order->shippingOption()->name() }}
@endif

{{-- @if($order->hasShippingAddress())
**Shipping Address:** {{ $order->shippingAddress() }}
@endif --}}

**Customer:** {{ $order->customer()->name }} ({{ $order->customer()->email }})

**Billing Address:** {{ $order->billingAddress() }}

@if($order->order_notes)
**Order Notes:** {{ $order->order_notes }}
@endif
</x-mail::panel>
</x-mail::message>
