<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->orderBy('sort_order')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $parents = Category::whereNull('parent_id')->get();
        return view('admin.categories.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_fa'        => 'required|string|max:255',
            'name_en'        => 'required|string|max:255',
            'description_fa' => 'nullable|string',
            'description_en' => 'nullable|string',
            'parent_id'      => 'nullable|exists:categories,id',
            'sort_order'     => 'nullable|integer',
        ]);
        $data['slug']   = Str::slug($request->name_en);
        $data['active'] = $request->has('active');
        Category::create($data);
        return redirect()->route('admin.categories.index')->with('success', 'دسته‌بندی ایجاد شد ✅');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $parents  = Category::whereNull('parent_id')->where('id', '!=', $id)->get();
        return view('admin.categories.edit', compact('category', 'parents'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $data = $request->validate([
            'name_fa'        => 'required|string|max:255',
            'name_en'        => 'required|string|max:255',
            'description_fa' => 'nullable|string',
            'description_en' => 'nullable|string',
            'parent_id'      => 'nullable|exists:categories,id',
            'sort_order'     => 'nullable|integer',
        ]);
        $data['active'] = $request->has('active');
        $category->update($data);
        return redirect()->route('admin.categories.index')->with('success', 'دسته‌بندی ویرایش شد ✅');
    }

    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        return redirect()->route('admin.categories.index')->with('success', 'دسته‌بندی حذف شد');
    }
}
