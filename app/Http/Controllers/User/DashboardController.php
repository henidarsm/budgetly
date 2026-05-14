<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Expense;
use App\Models\Category;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $totalExpenses   = Expense::where('user_id', $userId)->sum('amount');
        $thisMonth       = Expense::where('user_id', $userId)
                            ->whereMonth('expense_date', Carbon::now()->month)
                            ->whereYear('expense_date', Carbon::now()->year)
                            ->sum('amount');
        $lastMonth       = Expense::where('user_id', $userId)
                            ->whereMonth('expense_date', Carbon::now()->subMonth()->month)
                            ->whereYear('expense_date', Carbon::now()->subMonth()->year)
                            ->sum('amount');
        $totalCategories = Category::where(function($q) use ($userId) {
                            $q->where('user_id', $userId)->orWhereNull('user_id');
                        })->count();

        // Monthly data last 6 months
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthlyData[] = [
                'month' => $date->format('M Y'),
                'total' => Expense::where('user_id', $userId)
                    ->whereMonth('expense_date', $date->month)
                    ->whereYear('expense_date', $date->year)
                    ->sum('amount'),
            ];
        }

        // Category breakdown
        $categoryData = Category::whereHas('expenses', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->withSum(['expenses' => fn($q) => $q->where('user_id', $userId)], 'amount')
            ->orderByDesc('expenses_sum_amount')
            ->get();

        // Recent 5 expenses
        $recentExpenses = Expense::with('category')
            ->where('user_id', $userId)
            ->orderByDesc('expense_date')
            ->limit(5)
            ->get();

        // Top categories
        $topCategories = $categoryData->take(5);

        return view('user.dashboard', compact(
            'totalExpenses', 'thisMonth', 'lastMonth', 'totalCategories',
            'monthlyData', 'categoryData', 'recentExpenses', 'topCategories'
        ));
    }
}
