<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'user')->withCount('expenses')->withSum('expenses', 'amount');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('business_name', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->orderByDesc('created_at')->paginate(10)->withQueryString();
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $expenses = $user->expenses()->with('category')->orderByDesc('expense_date')->paginate(10);
        $totalExpense = $user->expenses()->sum('amount');
        return view('admin.users.show', compact('user', 'expenses', 'totalExpense'));
    }

    public function toggleStatus(User $user)
    {
        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();
        $status = $user->status === 'active' ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Akun {$user->name} berhasil {$status}.");
    }

    public function destroy(User $user)
    {
        $name = $user->name;
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', "Akun {$name} berhasil dihapus.");
    }
}
