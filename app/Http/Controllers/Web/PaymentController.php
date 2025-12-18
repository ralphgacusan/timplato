<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;

use Carbon\Carbon;

class PaymentController extends Controller
{
    public function salesAnalyticsPage(Request $request)
    {
        $from = $request->input('from_date') 
            ? Carbon::parse($request->input('from_date'))->startOfDay() 
            : now()->subDays(30)->startOfDay();

        $to = $request->input('to_date') 
            ? Carbon::parse($request->input('to_date'))->endOfDay() 
            : now()->endOfDay();

        // --- Summary metrics ---
        $totalRevenue = Payment::where('status', 'completed')
            ->whereBetween('paid_at', [$from, $to])
            ->sum('amount');

        $totalOrders = Order::whereBetween('created_at', [$from, $to])->count();

        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        $completedOrders = Order::where('current_status', 'delivered')
            ->whereBetween('created_at', [$from, $to])
            ->count();

        $conversionRate = $totalOrders > 0 ? round(($completedOrders / $totalOrders) * 100, 2) : 0;

        $totalCustomers = User::where('role', 'user')
            ->whereDate('created_at', '<=', $to)
            ->count();

        $newCustomers = User::where('role', 'user')
            ->whereBetween('created_at', [$from, $to])
            ->count();

        $avgLifetimeValue = $totalCustomers > 0 ? $totalRevenue / $totalCustomers : 0;

        // --- Daily chart data for all metrics ---
        $days = [];
        $revenues = [];
        $ordersData = [];
        $averageOrderValueData = [];
        $conversionRateData = [];
        $customersData = [];
        $lifetimeValueData = [];

        $period = new \DatePeriod($from, new \DateInterval('P1D'), $to->copy()->addDay());

        foreach ($period as $date) {
            $days[] = $date->format('M d');

            $dailyRevenue = Payment::where('status', 'completed')
                ->whereDate('paid_at', $date)
                ->sum('amount');

            $dailyOrders = Order::whereDate('created_at', $date)->count();

            $dailyCompletedOrders = Order::where('current_status', 'delivered')
                ->whereDate('created_at', $date)
                ->count();

            $dailyCustomers = User::where('role', 'user')
                ->whereDate('created_at', $date)
                ->count();

            $revenues[] = $dailyRevenue;
            $ordersData[] = $dailyOrders;
            $averageOrderValueData[] = $dailyOrders > 0 ? $dailyRevenue / $dailyOrders : 0;
            $conversionRateData[] = $dailyOrders > 0 ? round(($dailyCompletedOrders / $dailyOrders) * 100, 2) : 0;
            $customersData[] = $dailyCustomers;
            $lifetimeValueData[] = $dailyCustomers > 0 ? $dailyRevenue / $dailyCustomers : 0;
        }

        $data = [
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'averageOrderValue' => $averageOrderValue,
            'conversionRate' => $conversionRate,
            'totalCustomers' => $totalCustomers,
            'newCustomers' => $newCustomers,
            'avgLifetimeValue' => $avgLifetimeValue,
            'chartLabels' => $days,
            'chartRevenue' => $revenues,
            'chartOrders' => $ordersData,
            'chartAverageOrderValue' => $averageOrderValueData,
            'chartConversionRate' => $conversionRateData,
            'chartCustomers' => $customersData,
            'chartLifetimeValue' => $lifetimeValueData,
        ];

        $products = Product::orderByDesc('sold')->take(50)->get(); // get top 50 by sold, for example
        $categories = Category::orderBy('name')->get();

        return view('admin.sales-analytics', compact('data', 'products', 'categories'));
    }

    public function getProductAnalytics($productId, Request $request)
{
    $from = $request->input('from_date') 
        ? Carbon::parse($request->input('from_date'))->startOfDay() 
        : now()->subDays(30)->startOfDay();

    $to = $request->input('to_date') 
        ? Carbon::parse($request->input('to_date'))->endOfDay() 
        : now()->endOfDay();

    $product = Product::findOrFail($productId);

    // --- Aggregates for that product ---
    $totalOrders = $product->orderItems()
        ->whereHas('order', function ($q) use ($from, $to) {
            $q->whereBetween('created_at', [$from, $to]);
        })
        ->count();

    $totalUnitsSold = $product->orderItems()
        ->whereHas('order', function ($q) use ($from, $to) {
            $q->whereBetween('created_at', [$from, $to])
                ->where(function ($query) {
                    $query->where(function ($q1) {
                        $q1->where('payment_method', 'COD')
                            ->where('current_status', 'delivered');
                    })
                    ->orWhere(function ($q2) {
                        $q2->where('payment_method', '!=', 'COD')
                            ->where('current_status', 'confirmed');
                    });
                });
        })
        ->sum('quantity');

    $totalRevenue = $product->orderItems()
        ->whereHas('order', function ($q) use ($from, $to) {
            $q->whereBetween('created_at', [$from, $to])
                ->where(function ($query) {
                    $query->where(function ($q1) {
                        $q1->where('payment_method', 'COD')
                            ->where('current_status', 'delivered');
                    })
                    ->orWhere(function ($q2) {
                        $q2->where('payment_method', '!=', 'COD')
                            ->where('current_status', 'confirmed');
                    });
                });
        })
        ->sum(\DB::raw('quantity * price'));

    $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

    // --- Chart data: daily sales of that product ---
    $period = new \DatePeriod($from, new \DateInterval('P1D'), $to->copy()->addDay());
    $labels = [];
    $sales = [];

    foreach ($period as $date) {
        $labels[] = $date->format('M d');

        $dailySales = $product->orderItems()
            ->whereHas('order', function ($q) use ($date) {
                $q->whereDate('created_at', $date);
            })
            ->sum('quantity');

        $sales[] = $dailySales;
    }

    return response()->json([
        'name' => $product->name,
        'labels' => $labels,
        'sales' => $sales,
        'metrics' => [
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'totalUnitsSold' => $totalUnitsSold,
            'averageOrderValue' => $averageOrderValue,
        ]
    ]);
}

public function filterProducts(Request $request)
{
    $query = Product::query();

    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('category_id')) {
        $categoryId = $request->category_id;

        // Get the selected category and its child category IDs
        $categoryIds = \App\Models\Category::where('category_id', $categoryId)
            ->orWhere('parent_id', $categoryId)
            ->pluck('category_id')
            ->toArray();

        // Filter products that belong to this category or its subcategories
        $query->whereIn('category_id', $categoryIds);
    }

    $products = $query->orderByDesc('sold')->take(50)->get();

    return response()->json($products);
}




}
