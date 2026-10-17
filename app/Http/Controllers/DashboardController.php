<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCustomers = Customer::count();
        $totalCategories = Category::count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();

        $totalSales = Order::sum('total_amount');

        return response()->json([
            'success' => true,
            'totalCustomers' => $totalCustomers,
            'totalCategories' => $totalCategories,
            'totalProducts' => $totalProducts,
            'totalOrders' => $totalOrders,
            'totalSales' => number_format($totalSales, 2, '.', ''),
        ]);
    }
}