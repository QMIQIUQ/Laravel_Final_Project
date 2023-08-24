<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Point of Sale') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('error'))
            <script>
                // Use JavaScript to show a notification prompt
                alert("{{ session('error') }}");
            </script>
            @endif

            @if(session('success'))
            <script>
                // Use JavaScript to show a notification prompt for success message
                alert("{{ session('success') }}");
            </script>
            @endif

            <!-- Search Form -->
            <form action="{{ route('search') }}" method="POST">
                @csrf
                <label for="search" class="block text-sm mt-4">
                    <h3 class="text-gray-700 dark:text-gray-400">Insert Barcode:</h3>
                    <input type="text" id="barcode" name="barcode"
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        placeholder="Enter Barcode" required autofocus />
                </label>

                <button type="submit"
                    class="w-full px-4 py-2 mt-4 mb-4 text-sm text-white bg-gray-500 hover:bg-gray-800">Search</button>
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

            <div class="text-white gap-4 mx-auto">
                <div class="shadow-md rounded-lg ">
                    <div class="flex justify-between items-center ">
                        <h3 class="text-lg font-semibold mb-4">Cart :</h3>
                        <!-- Clear Cart Button -->
                        @if (count($cartItems) > 0)
                        <form action="{{ route('clearCart') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="bg-red-500 hover:bg-red-600 text-white px-4 rounded-md mt-4">Clear
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
                                    <form action="{{ route('removeFromCart', $item['id']) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Remove</button>
                                    </form>
                                </td>
                            </tr>
                            @php
                            $totalPrice += $item['price'] * $item['quantity'];
                            @endphp
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Payment Method Selection -->
                    <label class="block mt-4 text-gray-700 dark:text-gray-400">
                        <h3 class="text-gray-700 dark:text-gray-400">Payment Method:</h3>
                        <input type="radio" name="payment_method" value="cash" required> Cash
                        <input type="radio" name="payment_method" value="qr"> QR
                    </label>
                    <!-- Show input for cash amount if cash is selected -->
                    <div id="cash_amount_input" class="hidden">
                        <label for="cash_amount" class="block mt-4 text-gray-700 dark:text-gray-400">
                            <h3 class="text-gray-700 dark:text-gray-400">Insert Amount (more than total
                                price):</h3>
                            <input type="number" id="cash_amount" name="cash_amount"
                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                required />
                        </label>
                    </div>


                    <!-- Total Price and Checkout Button -->
                    <div dir="rtl" class="flex items-center">
                        <!-- Checkout Button -->
                        @if (count($cartItems) > 0)
                        <form action="{{ route('checkout') }}" method="POST">
                            @csrf
                            <input type="hidden" name="total_price" value="{{ $totalPrice }}">
                            <button type="submit" id="checkout_button" style="display: none; background-color: #4CAF50;"
                                class="text-white py-1 px-4 rounded-md">Checkout</button>
                        </form>
                        @endif
                        <div class="font-bold text-xl px-4">Total Price: {{ $totalPrice }}</div>
                    </div>


                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const cashAmountInput = document.getElementById('cash_amount_input');
                            const cashRadio = document.querySelector('input[name="payment_method"][value="cash"]');
                            const qrRadio = document.querySelector('input[name="payment_method"][value="qr"]');
                            const checkoutButton = document.getElementById('checkout_button');
                
                            cashRadio.addEventListener('change', () => {
                                cashAmountInput.style.display = cashRadio.checked ? 'block' : 'none';
                                checkoutButton.style.display = cashRadio.checked ? 'block' : 'none';
                            });
                
                            qrRadio.addEventListener('change', () => {
                                cashAmountInput.style.display = qrRadio.checked ? 'none' : 'block';
                                checkoutButton.style.display = qrRadio.checked ? 'block' : 'none';
                            });
                
                            const cashAmountField = document.getElementById('cash_amount');
                            const totalPrice = parseFloat("{{ $totalPrice }}"); // Convert the total price to a floating-point number
                
                            checkoutButton.addEventListener('click', function (event) {
                                if (cashRadio.checked) {
                                    const cashAmount = parseFloat(cashAmountField.value);
                                    if (isNaN(cashAmount) || cashAmount < totalPrice) {
                                        event.preventDefault(); // Prevent the form submission
                                        alert('Please enter an amount greater than or equal to the total price.');
                                    }
                                } else if (qrRadio.checked) {
                                    // Handle QR payment logic here
                                }
                            });
                
                            // Initially, hide the "Checkout" button
                            checkoutButton.style.display = 'none';
                
                            // Trigger the change event to initialize the UI state
                            if (qrRadio.checked) {
                                qrRadio.dispatchEvent(new Event('change'));
                            }
                        });
                    </script>

                    @else
                    <p>Your cart is empty.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>