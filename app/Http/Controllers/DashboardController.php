<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        // Retrieve all users with their total sales amount using a subquery
        $usersWithTotalSales = User::select('users.*')
            ->selectSub(function ($query) {
                $query->from('orders')
                    ->selectRaw('SUM(total_price)')
                    ->whereColumn('user_id', 'users.id');
            }, 'total_sales')
            ->get();

        return view('dashboard', ['usersWithTotalSales' => $usersWithTotalSales]);
    }

    public function getTotalSalesByMonth(Request $request)
{
    // Get the selected year and month from the request (assuming it's passed as 'year' and 'month')
    $selectedYear = $request->input('year');
    $selectedMonth = $request->input('month');

    // Query to get the total sales amount for each month
    $monthlySales = Order::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(total_price) as total_sales')
        ->groupBy('year', 'month')
        ->orderBy('year', 'asc')
        ->orderBy('month', 'asc')
        ->get();

    return response()->json($monthlySales);
}

public function getTotalSalesByDay(Request $request)
{
    // Get the selected date from the request (assuming it's passed as 'selected_date')
    $selectedDate = $request->input('selected_date');

    // Query to get the total sales amount for the selected day
    $dailySales = Order::selectRaw('DATE(created_at) as date, SUM(total_price) as total_sales')
        ->whereDate('created_at', $selectedDate)
        ->groupBy('date')
        ->get();

    return response()->json($dailySales);
}


}
