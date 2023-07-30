<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Point of Sale') }}
        </h2>
    </x-slot>
    <form action="{{ route('search') }}" method="POST">
        @csrf
        <label for="search" class="block text-sm mt-4 ">
            <h3 class="text-gray-700 dark:text-gray-400">Insert Barcode:</h3>
            <input type="text" id="barcode" name="barcode"
                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                placeholder="Enter Barcode" required autofocus/>
        </label>

        <button type="submit"
            class="w-full px-4 py-2 mt-4 mb-4 text-sm text-white bg-gray-500 hover:bg-gray-800">Search</button>
    </form>

    @if(session('error'))
    <script>
        // Use JavaScript to show a notification prompt
    alert("{{ session('error') }}");
    </script>
    @endif

    <style>
        table {
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid dimgray;
            padding: 5px;
        }
    </style>




    <div class=" text-white grid grid-cols-2 gap-4">
        <div class="shadow-md rounded-lg p-4">
            <div class="flex justify-between items-center ">
                <h3 class="text-lg font-semibold mb-4">Cart : </h3>
                <!-- Clear Cart Button -->
                @if (count($cartItems) > 0)
                <form action="{{ route('clearCart') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 rounded-md mt-4">Clear
                        Cart</button>
                </form>
                @endif
            </div>
            
            @if (count($cartItems) > 0)
            <table style="border: 1px solid dimgray; border-radius: 5px;" class=" table-auto w-full">
                <thead>
                    <tr>
                        <th class="border border-white px-4 py-2">Type</th>
                        <th class="border border-white px-4 py-2">Name</th>
                        <th class="border border-white px-4 py-2">Price</th>
                        <th class="border border-white px-4 py-2">Quantity</th>
                        <th class="border border-white px-4 py-2">Total Price</th>
                        <th class="border border-white px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $totalPrice = 0;
                    @endphp
                    @foreach($cartItems as $item)
                    <tr>
                        <td class="border border-white px-4 py-2">{{ $item['type'] }}</td>
                        <td class="border border-white px-4 py-2">{{ $item['name'] }}</td>
                        <td class="border border-white px-4 py-2">{{ $item['price'] }}</td>
                        <td class="border border-white px-4 py-2">{{ $item['quantity'] }}</td>
                        <td class="border border-white px-4 py-2">{{ $item['price'] * $item['quantity'] }}</td>
                        <td class="border border-white px-4 py-2">
                            <!-- Form to remove one quantity of the item -->
                            <form action="{{ route('removeFromCart', $item['id']) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600">Remove</button>
                            </form>
                        </td>
                    </tr>
                    @php
                    $totalPrice += $item['price'] * $item['quantity'];
                    @endphp
                    @endforeach
                </tbody>
            </table>
            <!-- Total Price and Checkout Button -->
            <div dir="rtl" class="flex items-center">
               
                <!-- Checkout Button -->
                @if (count($cartItems) > 0)
                <a href="{{ route('checkout') }}" style="background-color: #4CAF50;"
                    class="text-white py-1 px-4  rounded-md">Checkout</a>
                @endif
                <div class="font-bold text-xl px-4">Total Price: {{ $totalPrice }}</div>
            </div>
            
           
            @else
            <p>Your cart is empty.</p>
            @endif
        </div>
    </div>
</x-app-layout>