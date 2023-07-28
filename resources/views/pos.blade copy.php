<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Point of Sale') }}
        </h2>
    </x-slot>
    <form action="{{ route('pos.search') }}" method="POST" class="mb-4">
        @csrf
        <input type="text" name="barcode" class="border rounded-md px-3 py-2" placeholder="Enter Barcode" required>
        <button type="submit"
            class="ml-2 bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md focus:outline-none focus:ring">
            Enter
        </button>
    </form>
    <div class="text-white grid grid-cols-2 gap-4">


        
        <!-- Cart -->
        <div class="text-white">
            <h3 class="text-lg font-semibold mb-4">Cart</h3>
            <div class="shadow-md rounded-lg p-4">
                @if (count($cartItems) > 0)
                <ul class="space-y-2">
                    @foreach ($cartItems as $item)
                    <li>
                        <span class="font-semibold">{{ $item->name }}</span>
                        <span class="text-gray-500">{{ $item->description }}</span>
                        <span class="text-gray-600">x {{ $item->quantity }}</span>
                        <span class="float-right">${{ $item->price }}</span>
                        <form action="{{ route('pos.removeFromCart', ['id' => $item->id]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="text-red-600 hover:underline">
                                Remove
                            </button>
                        </form>
                    </li>
                    @endforeach
                </ul>
                <hr class="my-2">
                <div class="flex justify-between">
                    <span class="font-semibold">Total:</span>
                    <span class="font-semibold">${{ $total }}</span>
                </div>
                @else
                <p>Your cart is empty.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>