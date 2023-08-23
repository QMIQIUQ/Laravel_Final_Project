<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Order Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Add the back button -->
            <button class=" text-white font-bold py-2 px-4 rounded" onclick="window.history.back()">
                < Back
            </button>
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 mb-4">
                    Order #{{ $order->id }}
                </h3>
                <h4 class="font-semibold text-md text-gray-800 dark:text-gray-200 mb-4">
                    Done By: {{ $order->user->name }}
                </h4>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Date: {{ $order->created_at->format('M d, Y H:i A') }}
                </p>


                <h4 class="font-semibold text-md text-gray-800 dark:text-gray-200 mb-2">
                   <U>Order Items</U> 
                </h4>
                <ul class="list-disc pl-8 mb-4">
                    @foreach ($order->items as $item)
                        <li class="text-gray-400">{{ $item->product->item_name }} - Quantity: {{ $item->quantity }} - Unit Price: ${{ $item->unit_price }}</li>
                    @endforeach
                </ul>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Total Price: $ <u>{{ $order->total_price }}</u>
                </p>

                
            </div>
            <a href="{{ route('download.pdf', ['order' => $order->id]) }}" class=" text-green-600 font-bold py-2 px-4 rounded">
                Download Receipt (PDF)
            </a>
        </div>
    </div>

</x-app-layout>
