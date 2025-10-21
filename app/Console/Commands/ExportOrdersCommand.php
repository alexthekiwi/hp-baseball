<?php

namespace App\Console\Commands;

use App\Notifications\OrdersExportNotification;
use DuncanMcClean\Cargo\Facades\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use League\Csv\Writer;
use SplTempFileObject;

class ExportOrdersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:export-orders {--output=email} {--since=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export all orders to a spreadsheet for stock ordering';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $output = $this->option('output') ?? 'email';
        $since = Carbon::parse($this->option('since') ?? now()->startOfYear()->toDateString());

        // Get the orders to export
        $orders = Order::query()
            ->where('date', '>', $since)
            ->get();

        if ($orders->isEmpty()) {
            $this->warn('No orders found');

            return;
        }

        // Prepare to write CSV
        $csv = Writer::createFromFileObject(new SplTempFileObject);

        $headers = [
            'order_number',
            'date',
            'first_name',
            'last_name',
            'email',
            'billing_address',
            'total',
            'status',
            // Order item level fields
            'item',
            'variant',
            'sku',
            'quantity',
            // Just keep order notes at the end
            'notes',
        ];

        $csv->insertOne($headers);

        $rows = [];

        // Create a row for each order ITEM in each order
        foreach ($orders as $order) {
            foreach ($order->line_items as $item) {
                $product = $item['product'];
                $variant = $item['variant'];
                $billingAddress = collect([
                    $order['billing_line_1'] ?? null,
                    $order['billing_line_2'] ?? null,
                    $order['billing_city'] ?? null,
                    $order['billing_postcode'] ?? null,
                ])->filter()->join(', ');

                $amountPaid = $order->grand_total;

                $rows[] = [
                    $order->orderNumber,
                    $order->date->format('Y-m-d H:i:s'),
                    $order->customer['first_name'] ?? null,
                    $order->customer['last_name'] ?? null,
                    $order->customer['email'] ?? null,
                    $billingAddress,
                    $amountPaid,
                    $order->status,
                    $product->title ?? '',
                    $variant->name ?? '',
                    $variant->sku ?? '',
                    $item['quantity'] ?? 1,
                    $order->order_notes ?? '',
                ];
            }
        }

        if ($output === 'console') {
            $this->table($headers, $rows);

            return;
        }

        $csv->insertAll($rows);

        // Output the CSV
        $fileName = now()->format('Y-m-d').'_'.'Orders-Export.csv';
        $path = "order-exports/{$fileName}";

        Storage::put($path, $csv->toString());

        // Email the CSV to admin
        Notification::route('mail', config('mail.to.admin'))->notify(
            new OrdersExportNotification($path, $since)
        );
    }
}
