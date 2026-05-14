<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    private function getCategories()
    {
        return Category::where(function($q) {
            $q->where('user_id', Auth::id())->orWhereNull('user_id');
        })->orderBy('name')->get();
    }

    public function index(Request $request)
    {
        $query = Expense::with('category')->where('user_id', Auth::id());

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('expense_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('expense_date', '<=', $request->date_to);
        }

        $totalFiltered = (clone $query)->sum('amount');
        $expenses      = $query->orderByDesc('expense_date')->paginate(10)->withQueryString();
        $categories    = $this->getCategories();

        return view('user.expenses.index', compact('expenses', 'categories', 'totalFiltered'));
    }

    public function create()
    {
        $categories = $this->getCategories();
        return view('user.expenses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'amount'       => 'required|numeric|min:1',
            'category_id'  => 'required|exists:categories,id',
            'expense_date' => 'required|date',
            'description'  => 'nullable|string|max:500',
        ], [
            'title.required'        => 'Judul pengeluaran wajib diisi.',
            'amount.required'       => 'Jumlah pengeluaran wajib diisi.',
            'amount.min'            => 'Jumlah pengeluaran harus lebih dari 0.',
            'category_id.required'  => 'Kategori wajib dipilih.',
            'expense_date.required' => 'Tanggal pengeluaran wajib diisi.',
        ]);

        Expense::create([
            'user_id'      => Auth::id(),
            'category_id'  => $request->category_id,
            'title'        => $request->title,
            'amount'       => $request->amount,
            'expense_date' => $request->expense_date,
            'description'  => $request->description,
        ]);

        return redirect()->route('user.expenses.index')->with('success', 'Pengeluaran berhasil ditambahkan.');
    }

    public function edit(Expense $expense)
    {
        if ($expense->user_id !== Auth::id()) abort(403);
        $categories = $this->getCategories();
        return view('user.expenses.edit', compact('expense', 'categories'));
    }

    public function update(Request $request, Expense $expense)
    {
        if ($expense->user_id !== Auth::id()) abort(403);

        $request->validate([
            'title'        => 'required|string|max:255',
            'amount'       => 'required|numeric|min:1',
            'category_id'  => 'required|exists:categories,id',
            'expense_date' => 'required|date',
            'description'  => 'nullable|string|max:500',
        ]);

        $expense->update($request->only('title', 'amount', 'category_id', 'expense_date', 'description'));
        return redirect()->route('user.expenses.index')->with('success', 'Pengeluaran berhasil diperbarui.');
    }

    public function destroy(Expense $expense)
    {
        if ($expense->user_id !== Auth::id()) abort(403);
        $expense->delete();
        return back()->with('success', 'Pengeluaran berhasil dihapus.');
    }
}
