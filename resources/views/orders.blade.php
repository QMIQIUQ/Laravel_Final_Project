<!-- Include Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.3/dist/flatpickr.min.css">

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class=" flex items-center items-center">
                {{-- Search bar --}}
                <div class="flex-initial w-64">
                    <label for="search" class=" block text-sm mt-4">
                        <h2 class="text-gray-700 dark:text-gray-400">Search:</h2>
                        <input type="text" id="search" name="search"
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                            placeholder="Type to Search" required autofocus />
                    </label>
                </div>


                {{-- Date picker --}}
                <div class="w-1/6">
                    <label for="datepicker" class="block text-sm mt-4 ">
                        <h3 class="text-gray-700 dark:text-gray-400">Select Date:</h3>
                        <input type="text" id="datepicker"
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                            placeholder="Select Date" />
                    </label>
                </div>
                {{-- User filter --}}
                <div class="w-1/6">
                    <label for="userFilter" class="block text-sm mt-4">
                        <h3 class="text-gray-700 dark:text-gray-400">Filter by User:</h3>
                        <select id="userFilter"
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-select">
                            <option value="">All Users</option>
                            @foreach ($users as $user)
                            <option value="{{ $user->name }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
            </div>


            @foreach ($orders as $order)
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 mb-4">
                    <u>Order #{{ $order->id }}</u>
                </h3>
                <div class="mb-4">
                    <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Done By: {{ $order->user->name }}
                    </h4>

                </div>

                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Date: {{ $order->created_at->format('M d, Y H:i A') }}
                </p>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Total Price:<u>${{ $order->total_price }}</u>
                </p>

                <a href="{{ route('order.details', ['id' => $order->id]) }}" class="text-green-600">View
                    Details</a>
            </div>
            @endforeach

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.3/dist/flatpickr.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.getElementById("search");
            const orderContainers = document.querySelectorAll(".p-4");
            const datepicker = flatpickr("#datepicker", {
                dateFormat: "M d, Y", // Set the date picker format to "Jul 31, 2023"
                onClose: function (selectedDates) {
                    const selectedDate = selectedDates[0];
                    searchInput.value = selectedDate ? selectedDate.toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    }) : "";
                    filterOrders();
                }
            });

            searchInput.addEventListener("input", filterOrders);

            function filterOrders() {
                const searchQuery = searchInput.value.trim().toLowerCase();

                orderContainers.forEach((orderContainer) => {
                    const orderText = orderContainer.textContent.trim().toLowerCase();

                    if (orderText.includes(searchQuery)) {
                        orderContainer.style.display = "block";
                    } else {
                        orderContainer.style.display = "none";
                    }
                });
            }
            const userFilter = document.getElementById("userFilter");
        userFilter.addEventListener("change", function () {
            const selectedUserName = userFilter.value.trim().toLowerCase();
            if (selectedUserName) {
                searchInput.value = selectedUserName;
            } else {
                searchInput.value = "";
            }
            filterOrders();
        });
        });
    </script>
</x-app-layout>