<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $myCategories     = Category::where('user_id', Auth::id())->withCount('expenses')->get();
        $globalCategories = Category::whereNull('user_id')->withCount('expenses')->get();
        return view('user.categories.index', compact('myCategories', 'globalCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'color'       => 'required|string|max:7',
            'description' => 'nullable|string|max:255',
        ]);
        Category::create([
            'user_id'     => Auth::id(),
            'name'        => $request->name,
            'color'       => $request->color,
            'description' => $request->description,
            'is_global'   => false,
        ]);
        return back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, Category $category)
    {
        if ($category->user_id !== Auth::id()) abort(403);
        $request->validate([
            'name'        => 'required|string|max:100',
            'color'       => 'required|string|max:7',
            'description' => 'nullable|string|max:255',
        ]);
        $category->update($request->only('name', 'color', 'description'));
        return back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        if ($category->user_id !== Auth::id()) abort(403);
        if ($category->expenses()->count() > 0) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih digunakan.');
        }
        $category->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}
