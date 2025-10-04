<div class="border border-gray-200 shadow-sm rounded-xl">
    <div class="px-4 py-2 border-b border-gray-200 flex justify-between items-center gap-6">
        <h2 class="text-md">Export orders</h2>
        <form action="{{ route('orders-export.store') }}" method="POST" class="flex gap-4">
            @csrf
            <label class="flex gap-2 items-center">
                <span class="text-xs">Orders placed since:</span>
                <input type="date" name="date_from" value="{{ now()->startOfYear()->format('Y-m-d') }}" class="border border-gray-200 text-xs rounded-lg p-2">
            </label>
            <button class="rounded-lg border border-gray-200 text-xs px-3 py-2 shadow-sm hover:bg-gray-50">Run Export</button>
        </form>
    </div>
    <div class="flex flex-col gap-2 p-4 text-xs">
        <p>Here you can export orders for the season. A spreadsheet will be emailed to <strong>{{ config('mail.to.admin') }}</strong>.</p>
        @if (session()->has('success'))
            <p class="text-green-500">{{ session()->get('success') }}</p>
        @endif
        @if (session()->has('error'))
            <p class="text-red-600">{{ session()->get('error') }}</p>
        @endif
    </div>

</div>
