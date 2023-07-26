<x-app-layout>

    <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
        Add Product
    </h4>
    <form method="" action="">
        @csrf
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <div>
                <label class="block text-sm mt-4">
                    <span class="text-gray-700 dark:text-gray-400">Item Code</span>
                    <input
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        placeholder="Insert Barcode Value" />
                </label>
                <label class="block text-sm mt-4">
                    <span class="text-gray-700 dark:text-gray-400">Item Name</span>
                    <input
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        placeholder="Item Name" />
                </label>
                <label class="block text-sm mt-4">
                    <span class="text-gray-700 dark:text-gray-400">Item Price</span>
                    <input
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        placeholder="Item Price" />
                </label>
                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">
                        Item Type
                    </span>
                    <select selected=""
                        class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                        <option>Phone Case</option>

                        <optgroup label="Glass">
                            <option>Privacy</option>
                            <option>Clear</option>
                            <option>Matte</option>
                            <option>Silicon</option>
                        </optgroup>
                        <optgroup label="GADGETS">
                            <option>Charger</option>
                            <option>Wire</option>
                            <option>Powerbank</option>
                            <option>Headset</option>
                            <option>Speaker</option>
                        </optgroup>
                    </select>
                </label>

            </div>
            <div>
                <button class="w-full px-4 py-2 mt-4 mb-4 text-sm text-white bg-gray-500 hover:bg-gray-800">
                    Add Product
                </button>
            </div>
    </form>


</x-app-layout>