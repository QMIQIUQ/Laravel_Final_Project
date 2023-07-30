<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Register Product') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <form method="POST" action="{{ route('additems.store') }}">
                @csrf
                <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                    <div>
                        <label for="item_code" class="block text-sm mt-4">
                            <span class="text-gray-700 dark:text-gray-400">Item Code</span>
                            <input id="item_code" name="item_code"
                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                placeholder="Insert Barcode Value" required autofocus />
                        </label>
                        @error('item_code')
                        <div class="text-red-600 mt-2 text-sm">
                            {{ $message }}
                        </div>
                        @enderror

                        <label for="item_name" class="block text-sm mt-4">
                            <span class="text-gray-700 dark:text-gray-400">Item Name</span>
                            <input id="item_name" name="item_name"
                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                placeholder="Item Name" required />
                        </label>
                        @error('item_name')
                        <div class="text-red-600 mt-2 text-sm">
                            {{ $message }}
                        </div>
                        @enderror

                        <label for="item_price" class="block text-sm mt-4">
                            <span class="text-gray-700 dark:text-gray-400">Item Price</span>
                            <input id="item_price" name="item_price"
                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                placeholder="Item Price" required />
                        </label>
                        @error('item_price')
                        <div class="text-red-600 mt-2 text-sm">
                            {{$message}}
                        </div>
                        @enderror

                        <label for="item_type" class="block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Item Type</span>
                            <select id="item_type" name="item_type"
                                class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                required>
                                <option value="">Select Item Type</option>
                                <option value="Phone Case">Phone Case</option>
                                <optgroup label="Glass">
                                    <option value="Glass Privacy">Privacy</option>
                                    <option value="Glass Clear">Clear</option>
                                    <option value="Glass Matte">Matte</option>
                                    <option value="Glass Silicon">Silicon</option>
                                </optgroup>
                                <optgroup label="GADGETS">
                                    <option value="Charger">Charger</option>
                                    <option value="Wire">Wire</option>
                                    <option value="Powerbank">Powerbank</option>
                                    <option value="Headset">Headset</option>
                                    <option value="Speaker">Speaker</option>
                                    <option value="Others">Others</option>
                                </optgroup>
                            </select>
                        </label>
                        @error('item_type')
                        <div class="text-red-600 mt-2 text-sm">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>
                    <div>
                        <button type="submit"
                            class="w-full px-4 py-2 mt-4 mb-4 text-sm text-white bg-gray-500 hover:bg-gray-800">
                            Add Product
                        </button>
                    </div>
                </div>
            </form>
            <div class="">









            </div>


            <!-- Check for success message and display notification -->

            <div>
                @if(Session::has('success'))
                <div class=" px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold text-white">Success!</strong>
                    <span class="block sm:inline dark:text-gray-400">{{ Session::get('success') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-green-500" role="button"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <title>Close</title>
                            <path
                                d="M14.348 14.849a1.2 1.2 0 01-1.697 1.697l-2.651-2.65-2.65 2.65a1.2 1.2 0 11-1.697-1.697l2.65-2.65-2.65-2.651a1.2 1.2 0 111.697-1.697l2.65 2.65 2.651-2.65a1.2 1.2 0 111.697 1.697l-2.65 2.65 2.65 2.651z" />
                        </svg>
                    </span>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>