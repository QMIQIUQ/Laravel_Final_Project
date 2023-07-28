<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Point of Sale') }}
        </h2>
    </x-slot>
    <form action="{{ route('search') }}" method="POST">
        @csrf
        <label for="barcode">Search for Barcode:</label>
        <input type="text" name="barcode" id="barcode class=" border rounded-md px-3 py-2" placeholder="Enter Barcode"
            required">
        <button type="submit"
            class="ml-2 bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md focus:outline-none focus:ring">Search</button>
    </form>

    <div class="text-white grid grid-cols-2 gap-4">
        <div class="shadow-md rounded-lg p-4">
            @if(session('item'))
            <h2>Item found and added to cart:</h2>
            <p>Name: {{ session('item')['name'] }}</p>
            <p>Price: {{ session('item')['price'] }}</p>
            <p>Type: {{ session('item')['type'] }}</p> <!-- Display item type -->
            <form action="{{ route('addToCart', session('item')['id']) }}" method="POST">
                <!-- Quantity input and Add to Cart button -->
            </form>
            @endif

            <h3 class="text-lg font-semibold mb-4">Cart : </h3>
            <ul>
                @if (count($cartItems) > 0)
                @foreach($cartItems as $item)
                <li>
                    Type: {{ $item['type'] }} | Name: {{ $item['name'] }} | Price: {{ $item['price'] }} | Quantity: {{ $item['quantity'] }} |
                    <form action="{{ route('removeFromCart', $item['id']) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE') <!-- Add the DELETE method -->
                        <button type="submit" class="text-red-500 ml-2">Remove</button>
                    </form>
                </li>
                @endforeach
                @else
                <p>Your cart is empty.</p>
                @endif
            </ul>
        </div>
    </div>

</x-app-layout>