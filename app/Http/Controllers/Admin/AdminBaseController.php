<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Tour;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AdminBaseController extends Controller
{
    public function index()
    {
        $totalRevenue = Order::where('status', 'COMPLETED')->sum('total_price');
        $totalOrders = Order::count();
        $totalCustomers = User::where('role', 'user')->count();
        $totalTours = Tour::count();

        $totalVisits = Visitor::count();
        $todayVisits = Visitor::whereDate('visited_at', today())->count();
        $sevenDayVisits = Visitor::where('visited_at', '>=', now()->subDays(7))->count();
        $thirtyDayVisits = Visitor::where('visited_at', '>=', now()->subDays(30))->count();

        return view("admin.modules.dashboard.index", compact(
            'totalRevenue',
            'totalOrders',
            'totalCustomers',
            'totalTours',
            'totalVisits',
            'todayVisits',
            'sevenDayVisits',
            'thirtyDayVisits'
        ));
    }

    public function getChartData(Request $request): JsonResponse
    {
        $filter = $request->get('filter', 'month');
        $today = Carbon::now();
        $labels = [];
        $revenueData = [];
        $orderData = [];

        $baseQuery = Order::query()->where('status', 'COMPLETED');

        switch ($filter) {
            case 'year':
                $dataPoints = (clone $baseQuery)
                    ->whereYear('created_at', $today->year)
                    ->select(
                        DB::raw("DATE_FORMAT(created_at, '%Y-%m') as date"),
                        DB::raw('SUM(total_price) as total_revenue'),
                        DB::raw('COUNT(*) as total_orders')
                    )->groupBy('date')->get()->keyBy('date');

                for ($i = 1; $i <= 12; $i++) {
                    $key = $today->copy()->month($i)->format('Y-m');
                    $labels[] = "Tháng $i";
                    $revenueData[] = $dataPoints->get($key)->total_revenue ?? 0;
                    $orderData[] = $dataPoints->get($key)->total_orders ?? 0;
                }
                break;

            case 'quarter':
                $startOfQuarter = $today->copy()->startOfQuarter();
                $endOfQuarter = $today->copy()->endOfQuarter();
                $dataPoints = (clone $baseQuery)
                    ->whereBetween('created_at', [$startOfQuarter, $endOfQuarter])
                    ->select(
                        DB::raw("DATE_FORMAT(created_at, '%Y-%m') as date"),
                        DB::raw('SUM(total_price) as total_revenue'),
                        DB::raw('COUNT(*) as total_orders')
                    )->groupBy('date')->get()->keyBy('date');

                $currentMonth = $startOfQuarter->copy();
                while ($currentMonth->lte($endOfQuarter)) {
                    $key = $currentMonth->format('Y-m');
                    $labels[] = 'Tháng ' . $currentMonth->month;
                    $revenueData[] = $dataPoints->get($key)->total_revenue ?? 0;
                    $orderData[] = $dataPoints->get($key)->total_orders ?? 0;
                    $currentMonth->addMonth();
                }
                break;

            case 'month':
                $startOfMonth = $today->copy()->startOfMonth();
                $endOfMonth = $today->copy()->endOfMonth();
                $dataPoints = (clone $baseQuery)
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                    ->select(
                        DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date"),
                        DB::raw('SUM(total_price) as total_revenue'),
                        DB::raw('COUNT(*) as total_orders')
                    )->groupBy('date')->get()->keyBy('date');

                $dateIterator = $startOfMonth->copy();
                while ($dateIterator->lte($endOfMonth)) {
                    $key = $dateIterator->format('Y-m-d');
                    $labels[] = $dateIterator->format('d/m');
                    $revenueData[] = $dataPoints->get($key)->total_revenue ?? 0;
                    $orderData[] = $dataPoints->get($key)->total_orders ?? 0;
                    $dateIterator->addDay();
                }
                break;

            case 'week':
            default:
                $startOfWeek = $today->copy()->startOfWeek();
                $endOfWeek = $today->copy()->endOfWeek();
                $dataPoints = (clone $baseQuery)
                    ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                    ->select(
                        DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date"),
                        DB::raw('SUM(total_price) as total_revenue'),
                        DB::raw('COUNT(*) as total_orders')
                    )->groupBy('date')->get()->keyBy('date');

                $dateIterator = $startOfWeek->copy();
                for ($i = 0; $i < 7; $i++) {
                    $key = $dateIterator->format('Y-m-d');
                    $labels[] = $dateIterator->format('d/m');
                    $revenueData[] = $dataPoints->get($key)->total_revenue ?? 0;
                    $orderData[] = $dataPoints->get($key)->total_orders ?? 0;
                    $dateIterator->addDay();
                }
                break;
        }

        return response()->json([
            'labels' => $labels,
            'revenue' => $revenueData,
            'orders' => $orderData,
        ]);
    }

    public function getVisitorChartData(Request $request): JsonResponse
    {
        $filter = $request->get('filter', 'week');
        $today = Carbon::now();
        $labels = [];
        $totalVisitsData = [];
        $uniqueVisitorsData = [];

        $query = Visitor::query();
        $dateFormat = '%Y-%m-%d';

        switch ($filter) {
            case 'year':
                $startDate = $today->copy()->startOfYear();
                $endDate = $today->copy()->endOfYear();
                $dateFormat = '%Y-%m';
                break;
            case 'quarter':
                $startDate = $today->copy()->startOfQuarter();
                $endDate = $today->copy()->endOfQuarter();
                $dateFormat = '%Y-%m';
                break;
            case 'month':
                $startDate = $today->copy()->startOfMonth();
                $endDate = $today->copy()->endOfMonth();
                break;
            case 'week':
            default:
                $startDate = $today->copy()->subDays(6)->startOfDay();
                $endDate = $today->copy()->endOfDay();
                break;
        }

        $visits = $query->whereBetween('visited_at', [$startDate, $endDate])
            ->select(
                DB::raw("DATE_FORMAT(visited_at, '$dateFormat') as date"),
                DB::raw('COUNT(*) as total_visits'),
                DB::raw('COUNT(DISTINCT ip_address) as unique_visitors')
            )
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get()->keyBy('date');

        $dateIterator = $startDate->copy();
        while ($dateIterator->lte($endDate)) {
            if ($filter === 'year' || $filter === 'quarter') {
                $key = $dateIterator->format('Y-m');
                $labels[] = 'Tháng ' . $dateIterator->month;
                $dateIterator->addMonth();
            } else {
                $key = $dateIterator->format('Y-m-d');
                $labels[] = $dateIterator->format('d/m');
                $dateIterator->addDay();
            }
            $totalVisitsData[] = $visits->get($key)->total_visits ?? 0;
            $uniqueVisitorsData[] = $visits->get($key)->unique_visitors ?? 0;
        }

        return response()->json([
            'labels' => $labels,
            'total_visits' => $totalVisitsData,
            'unique_visitors' => $uniqueVisitorsData,
        ]);
    }
}
