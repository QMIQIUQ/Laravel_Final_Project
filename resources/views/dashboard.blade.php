<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-3xl font-bold mb-2">Welcome</h1>
                    
                    @if (auth()->user() && auth()->user()->user_role == 0)
                    <!-- Placeholder for Monthly Sales Bar Chart -->
                    <h3>Total Sales</h3>
                    <div id="monthlySalesChartContainer">
                        <canvas id="monthlySalesChart"></canvas>
                    </div>

                    <!-- Display total sales for each user -->
                    <h3>Total Sales by User:</h3>
                    <div id="userSalesChartContainer">
                        <canvas id="userSalesChart"></canvas>
                    </div>

                    <!-- Date Picker -->
                    <div class="mt-4">
                        <label for="datePicker" class="block font-medium text-white">Select a Date:</label>
                        <input type="date" id="datePicker"
                            class="text-black mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-500 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
                    </div>
                    <!-- Placeholder for Daily Sales Bar Chart -->
                    <div id="dailySalesChartContainer">
                        <canvas id="dailySalesChart"></canvas>
                    </div>
                    @endif


                </div>
            </div>
        </div>
    </div>

    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        var dailySalesChart; // Declare a variable to store the reference to the chart

// Function to create and render a bar chart for daily sales
function renderDailySalesChart(data) {
    var labels = data.map(item => item.date);
    var salesData = data.map(item => item.total_sales);

    var ctx = document.getElementById('dailySalesChart').getContext('2d');

    // Destroy previous chart before rendering a new one
    if (dailySalesChart) {
        dailySalesChart.destroy();
    }

    dailySalesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Sales',
                data: salesData,
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

// Function to fetch the daily sales data using AJAX
function fetchDailySalesData(selectedDate) {
    $.ajax({
        url: '{{ route('getTotalSalesByDay') }}',
        type: 'GET',
        dataType: 'json',
        data: {
            selected_date: selectedDate
        },
        success: function (data) {
            renderDailySalesChart(data);
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
}

// Event listener for date picker change
$('#datePicker').change(function () {
    var selectedDate = $(this).val();
    fetchDailySalesData(selectedDate);
});

// Call the function to fetch and render the daily sales chart initially for the current date
var currentDate = new Date().toISOString().slice(0, 10); // Get the current date in YYYY-MM-DD format
$('#datePicker').val(currentDate); // Set the date picker value to the current date
fetchDailySalesData(currentDate);


        // Function to create and render a bar chart for monthly sales
    function renderMonthlySalesChart(data) {
        var labels = data.map(item => `${item.year}-${item.month}`);
        var salesData = data.map(item => item.total_sales);

        var ctx = document.getElementById('monthlySalesChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Sales',
                    data: salesData,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // Function to fetch the monthly sales data using AJAX
    function fetchMonthlySalesData(year, month) {
        $.ajax({
            url: '{{ route('getTotalSalesByMonth') }}',
            type: 'GET',
            dataType: 'json',
            data: {
                year: year,
                month: month
            },
            success: function (data) {
                renderMonthlySalesChart(data);
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    }

    // Call the function to fetch and render the monthly sales chart initially for the current year and month
    var currentDate = new Date();
    var currentYear = currentDate.getFullYear();
    var currentMonth = currentDate.getMonth() + 1; // Note: January is 0, so we add 1 to get the correct month
    fetchMonthlySalesData(currentYear, currentMonth);

        // Assuming you have passed the data from the controller to the view as $usersWithTotalSales
        var usersData = {!! json_encode($usersWithTotalSales) !!};

        // Function to create and render a bar chart for user sales
        function renderUserSalesChart() {
            var labels = usersData.map(user => user.name);
            var data = usersData.map(user => user.total_sales);

            var ctx = document.getElementById('userSalesChart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Sales',
                        data: data,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Fetch and render the Day Bar Chart, Week Bar Chart, Month Bar Chart, and Year Bar Chart (existing code)

        // Call the function to render the user sales chart
        renderUserSalesChart();

        
    </script>
</x-app-layout>