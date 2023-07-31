<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\User;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        $users = User::all(); // Fetch all users from the database

        return view('orders', compact('orders', 'users'));
    }

    public function show($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        $users = User::all(); // Fetch all users from the database

        return view('order_detail', compact('order', 'users'));
    }
}