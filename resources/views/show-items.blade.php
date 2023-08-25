<x-app-layout>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Product List') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Add Product Button -->
            <h2 style="color: lightgreen">
                <a href="{{ route('additems') }}" class="text-lg font-semibold mb-4 pt-4 hover:underline">Click here to
                    Register Product</a>
            </h2>



            <!-- Check for success message and display notification -->
            <div>
                @if(Session::has('success'))
                <div class="px-4 py-3 mb-4 bg-green-300 rounded-lg">
                    {{ Session::get('success') }}
                </div>
                @endif
            </div>

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


            <!-- Table to show all products -->
            <div class="mt-8 dark:text-white">
                {{-- search bar --}}
                <label for="search" class="block text-sm mt-4 ">
                    <h3 class="text-gray-700 dark:text-gray-400">Search:</h3>
                    <input type="text" id="search" name="search"
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        placeholder="Type to Search" required />
                </label>
                <h2 class="text-lg font-semibold mb-4 pt-4">All Products</h2>
                <div class="overflow-x-auto rounded-md ">
                    <table style="border: 1px solid dimgray; border-radius: 5px;" class=" table-auto w-full ">
                        <thead>
                            <tr>
                                <th class=" px-4 py-2">Item Code</th>
                                <th class=" px-4 py-2">Item Name</th>
                                <th class=" px-4 py-2">Item Price</th>
                                <th class=" px-4 py-2">Item Type</th>
                                <th class=" px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td class="px-4 py-2">{{ $product->item_code }}</td>
                                <td class="px-4 py-2">{{ $product->item_name }}</td>
                                <td class="px-4 py-2">$ {{ $product->item_price }}</td>
                                <td class="px-4 py-2">{{ $product->item_type }}</td>
                                <td class="px-4 py-2 text-center">
                                    <a href="{{ route('edit', ['id' => $product->id]) }}"
                                        style="color: rgb(193, 223, 154)" class=" hover:underline">Edit</a>
                                    <form class="inline" method="POST"
                                        action="{{ route('delete', ['id' => $product->id]) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" style="" class="text-red-600 hover:underline"
                                            onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


<script>
    $(document).ready(function () {
        $("#search").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("table tbody tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
    });
</script>