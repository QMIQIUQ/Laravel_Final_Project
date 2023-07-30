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

    <div class="text-white grid grid-cols-2 gap-4">
        <div class="shadow-md rounded-lg p-4">
            <!-- Rest of the content -->
            <h3 class="text-lg font-semibold mb-4">Cart : </h3>
            @if (count($cartItems) > 0)
            <table style="border: 1px solid dimgray; border-radius: 5px;" class=" table-auto w-full ">
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
                    @endforeach
                </tbody>
            </table>
            @else
            <p>Your cart is empty.</p>
            @endif

            <!-- Button to clear the entire cart -->
            <form action="{{ route('clearCart') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-md mt-4">Clear Cart</button>
            </form>
        </div>
    </div>
</x-app-layout>
