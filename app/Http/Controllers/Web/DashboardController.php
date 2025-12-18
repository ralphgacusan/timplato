<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ----- Top KPIs -----
        // Only consider completed payments for revenue
        $totalRevenue = Order::whereHas('payments', function($q) {
            $q->where('status', 'completed');
        })->sum('total_amount');

        // Only customers (exclude admins)
        $totalCustomers = User::where('role', 'user')->count();

        // Only orders with at least one completed payment
        $totalOrders = Order::whereHas('payments', function($q) {
            $q->where('status', 'completed');
        })->count();

        $conversionRate = $totalCustomers > 0 ? ($totalOrders / $totalCustomers) * 100 : 0;

        // Revenue trend compared to last month (only completed payments)
        $lastMonthRevenue = Order::whereHas('payments', function($q) {
            $q->where('status', 'completed');
        })
        ->whereMonth('created_at', now()->subMonth()->month)
        ->sum('total_amount');

        $revenueTrend = $lastMonthRevenue > 0
            ? round((($totalRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1) . '%'
            : null;

        // ----- Charts Data -----
        // Sales Overview (Revenue by month, only completed payments)
        $salesOverview = Order::whereHas('payments', function($q) {
            $q->where('status', 'completed');
        })
        ->selectRaw('MONTH(created_at) as month, SUM(total_amount) as revenue')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('revenue', 'month')
        ->toArray();

        $salesChart = array_map(fn($i) => $salesOverview[$i] ?? 0, range(1, 12));

        // Orders by month (only completed payments)
        $ordersByMonth = Order::whereHas('payments', function($q) {
            $q->where('status', 'completed');
        })
        ->selectRaw('MONTH(created_at) as month, COUNT(*) as orders')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('orders', 'month')
        ->toArray();

        $ordersChart = array_map(fn($i) => $ordersByMonth[$i] ?? 0, range(1, 12));

        // Sales by main category only
        $salesByCategory = DB::table('products')
            ->join('order_items', 'products.product_id', '=', 'order_items.product_id')
            ->join('categories as c', 'products.category_id', '=', 'c.category_id')
            ->leftJoin('categories as parent', 'c.parent_id', '=', 'parent.category_id')
            ->join('orders', 'orders.order_id', '=', 'order_items.order_id')
            ->join('payments', 'payments.order_id', '=', 'orders.order_id')
            ->where('payments.status', 'completed')
            ->selectRaw('COALESCE(parent.name, c.name) as category, SUM(order_items.quantity * order_items.price) as total')
            ->groupBy('category')
            ->pluck('total', 'category')
            ->toArray();

        // Quick stats
        $totalProducts = Product::count();
        // Products added this month
        $productsAddedThisMonth = Product::whereMonth('created_at', now()->month)->count();
        $lowStock = Product::whereColumn('stock_quantity', '<', 'restock_level')->count();
        $pendingOrders = Order::where('current_status', 'pending')->count();
        $newCustomersThisMonth = User::where('role', 'user')->whereMonth('created_at', now()->month)->count();



        return view('admin.dashboard', [
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'totalCustomers' => $totalCustomers,
            'conversionRate' => round($conversionRate, 1),

            'salesChart' => $salesChart,
            'ordersChart' => $ordersChart,
            'salesByCategoryChart' => $salesByCategory,

            'totalProducts' => $totalProducts,
            'productsAddedThisMonth' => $productsAddedThisMonth,
            'lowStock' => $lowStock,
            'pendingOrders' => $pendingOrders,
            'newCustomersThisMonth' => $newCustomersThisMonth,
            'revenueTrend' => $revenueTrend,
        ]);
    }
}
