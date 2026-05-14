<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers     = User::where('role', 'user')->count();
        $activeUsers    = User::where('role', 'user')->where('status', 'active')->count();
        $totalExpenses  = Expense::sum('amount');
        $totalCategories= Category::count();
        $thisMonth      = Expense::whereMonth('expense_date', Carbon::now()->month)
                            ->whereYear('expense_date', Carbon::now()->year)
                            ->sum('amount');
        $lastMonth      = Expense::whereMonth('expense_date', Carbon::now()->subMonth()->month)
                            ->whereYear('expense_date', Carbon::now()->subMonth()->year)
                            ->sum('amount');

        // Chart: Monthly expenses last 6 months
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthlyData[] = [
                'month' => $date->format('M Y'),
                'total' => Expense::whereMonth('expense_date', $date->month)
                    ->whereYear('expense_date', $date->year)
                    ->sum('amount'),
            ];
        }

        // Chart: Expenses by category
        $categoryData = Category::withSum('expenses', 'amount')
            ->having('expenses_sum_amount', '>', 0)
            ->orderByDesc('expenses_sum_amount')
            ->get();

        // Recent expenses
        $recentExpenses = Expense::with(['user', 'category'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        // Top users by expense
        $topUsers = User::where('role', 'user')
            ->withSum('expenses', 'amount')
            ->orderByDesc('expenses_sum_amount')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'activeUsers', 'totalExpenses', 'totalCategories',
            'thisMonth', 'lastMonth', 'monthlyData', 'categoryData',
            'recentExpenses', 'topUsers'
        ));
    }
}
