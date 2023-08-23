<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Add the back button -->
            <button class=" text-white font-bold py-2 px-4 rounded"
                onclick="window.history.back()">
                < Back </button>
                    <form method="POST" action="{{ route('update', ['id' => $product->id]) }}">
                        @csrf
                        @method('PUT')
                        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                            <div>
                                <label for="item_code" class="block text-sm mt-4">
                                    <span class="text-gray-700 dark:text-gray-400">Item Code</span>
                                    <input id="item_code" name="item_code" type="text" value="{{ $product->item_code }}"
                                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                        placeholder="Insert Barcode Value" required />
                                </label>
                                <label for="item_name" class="block text-sm mt-4">
                                    <span class="text-gray-700 dark:text-gray-400">Item Name</span>
                                    <input id="item_name" name="item_name" type="text" value="{{ $product->item_name }}"
                                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                        placeholder="Item Name" required />
                                </label>
                                <label for="item_price" class="block text-sm mt-4">
                                    <span class="text-gray-700 dark:text-gray-400">Item Price</span>
                                    <input id="item_price" name="item_price" type="number" step="0.01"
                                        value="{{ $product->item_price }}"
                                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                        placeholder="Item Price" required />
                                </label>
                                <label for="item_type" class="block mt-4 text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Item Type</span>
                                    <select id="item_type" name="item_type"
                                        class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                        required>
                                        <option value="">Select Item Type</option>
                                        <option value="Phone Case" @if ($product->item_type === 'Phone Case') selected
                                            @endif>Phone Case</option>
                                        <optgroup label="Glass">
                                            <option value="Glass Privacy" @if ($product->item_type === 'Glass Privacy')
                                                selected @endif>Privacy</option>
                                            <option value="Glass Clear" @if ($product->item_type === 'Glass Clear')
                                                selected @endif>Clear</option>
                                            <option value="Glass Matte" @if ($product->item_type === 'Glass Matte')
                                                selected @endif>Matte</option>
                                            <option value="Glass Silicon" @if ($product->item_type === 'Glass Silicon')
                                                selected @endif>Silicon</option>
                                        </optgroup>
                                        <optgroup label="GADGETS">
                                            <option value="Charger" @if ($product->item_type === 'Charger') selected
                                                @endif>Charger</option>
                                            <option value="Wire" @if ($product->item_type === 'Wire') selected
                                                @endif>Wire</option>
                                            <option value="Powerbank" @if ($product->item_type === 'Powerbank') selected
                                                @endif>Powerbank</option>
                                            <option value="Headset" @if ($product->item_type === 'Headset') selected
                                                @endif>Headset</option>
                                            <option value="Speaker" @if ($product->item_type === 'Speaker') selected
                                                @endif>Speaker</option>
                                            <option value="Others" @if ($product->item_type === 'Others') selected
                                                @endif>Others</option>
                                            </option>
                                        </optgroup>
                                    </select>
                                </label>
                            </div>
                            <div>
                                <button type="submit"
                                    class="w-full px-4 py-2 mt-4 mb-4 text-sm text-white bg-gray-500 hover:bg-gray-800">
                                    Update Product
                                </button>
                            </div>
                        </div>
                    </form>
        </div>
    </div>
</x-app-layout>