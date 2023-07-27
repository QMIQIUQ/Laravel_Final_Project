<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Product List') }}
        </h2>
    </x-slot>

    <form method="POST" action="{{ route('additems.store') }}">
        @csrf
        <!-- ... The form inputs ... -->
    </form>

    <div class="dark:text-gray-400">
        <!-- Error messages -->
    </div>

     <!-- Check for success message and display notification -->
     <div>
        @if(Session::has('success'))
            <div class="px-4 py-3 mb-4 bg-green-300 text-red-600 rounded-lg">
                {{ Session::get('success') }}
            </div>
        @endif
    </div>

    <style>
        table {
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid dimgray;
            padding: 5px;
        }

    </style>
    <!-- Table to show all products -->
    <div class="mt-8 dark:text-white">
        <h2 class="text-lg font-semibold mb-4">All Products</h2>
        <div class="overflow-x-auto rounded-md ">
            <table style="border: 1px solid dimgray; border-radius: 5px;" class=" table-auto w-full ">
                <thead>
                    <tr >
                        <th class=" px-4 py-2">Item Code</th>
                        <th class=" px-4 py-2">Item Name</th>
                        <th class=" px-4 py-2">Item Price</th>
                        <th class=" px-4 py-2">Item Type</th>
                        <th class=" px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody >
                    @foreach($products as $product)
                    <tr >
                        <td class="px-4 py-2">{{ $product->item_code }}</td>
                        <td class="px-4 py-2">{{ $product->item_name }}</td>
                        <td class="px-4 py-2">{{ $product->item_price }}</td>
                        <td class="px-4 py-2">{{ $product->item_type }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('edit', ['id' => $product->id]) }}" style="color: yellow" class=" hover:underline">Edit</a>
                            <form class="inline" method="POST" action="{{ route('delete', ['id' => $product->id]) }}">
                                @csrf
                                @method('DELETE')

                                <button type="submit" style="" class="text-red-600 hover:underline" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
