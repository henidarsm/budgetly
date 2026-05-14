<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('expenses')->orderBy('name')->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'color'       => 'required|string|max:7',
            'description' => 'nullable|string|max:255',
        ]);
        Category::create([
            'user_id'     => null,
            'name'        => $request->name,
            'color'       => $request->color,
            'description' => $request->description,
            'is_global'   => true,
        ]);
        return back()->with('success', 'Kategori global berhasil ditambahkan.');
    }

    public function update(Request $request, Category $category)
    {
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
        if ($category->expenses()->count() > 0) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh pengeluaran.');
        }
        $category->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}
