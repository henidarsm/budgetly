<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::with(['user', 'category']);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('expense_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('expense_date', '<=', $request->date_to);
        }

        $expenses   = $query->orderByDesc('expense_date')->paginate(15)->withQueryString();
        $categories = Category::all();
        $users      = User::where('role', 'user')->get();
        $totalFiltered = $query->sum('amount');

        return view('admin.expenses.index', compact('expenses', 'categories', 'users', 'totalFiltered'));
    }

    public function destroy(Expense $expense)
    {
        $title = $expense->title;
        $expense->delete();
        return back()->with('success', "Pengeluaran \"{$title}\" berhasil dihapus.");
    }
}
