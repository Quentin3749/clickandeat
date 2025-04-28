<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Order;

class AdminController extends Controller
{
    public function dashboard()
    {
        $clients = User::where('role', 'client')->count();
        $restaurateurs = User::where('role', 'restaurateur')->count();
        $restaurants = Restaurant::count();
        $orders = Order::count();
        return view('admin.dashboard', compact('clients', 'restaurateurs', 'restaurants', 'orders'));
    }
}
