<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $pageTitle = 'Categories';
        $categories = Category::all();
        return view('admin.Question.category', compact('categories','pageTitle'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|string',
            'difficulty_level' => 'required|integer|in:1,2,3',
            'score' => 'required|integer',
        ]);

        Category::create($validatedData);

        return redirect()->route('admin.categories.index')->with('success', 'Category added successfully!');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'score' => 'required|integer',
        ]);

        $category = Category::findOrFail($id);
        $category->update($validatedData);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully!');
    }
}
