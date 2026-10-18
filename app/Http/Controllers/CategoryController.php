<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('repairRequests')->latest()->get();
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create($request->only('name'));

        return back()->with('success', 'เพิ่มหมวดหมู่งานซ่อมเรียบร้อยแล้ว');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update($request->only('name'));

        return back()->with('success', 'แก้ไขหมวดหมู่งานซ่อมเรียบร้อยแล้ว');
    }

    public function destroy(Category $category)
    {
        if ($category->repair_requests_count > 0) {
            return back()->with('error', 'ไม่สามารถลบหมวดหมู่นี้ได้เนื่องจากมีรายการแจ้งซ่อมใช้งานอยู่');
        }

        $category->delete();

        return back()->with('success', 'ลบหมวดหมู่งานซ่อมเรียบร้อยแล้ว');
    }
}
