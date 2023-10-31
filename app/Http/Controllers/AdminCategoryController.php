<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Cache;
use DB;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Cache::remember('categories', 120, function () {
            return Category::all();
        });
        
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|unique:categories|max:255',
        ]);

        Category::create($validated);

        Cache::forget('categories');

        $categories = Cache::remember('categories', 120, function () {
            return Category::all();
        });

        return redirect()->route('admin.categories.index')->with('success', 'Category has been created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', [
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $rules = [
            'name' => 'required|max:255',
        ];

        if ($request->slug !== $category->slug) {
            $rules['slug'] = 'required|unique:categories|max:255';
        }

        $validated = $request->validate($rules);

        Category::where('id', $category->id)->update($validated);

        Cache::forget('categories');
        $categories = Cache::remember('categories', 120, function () {
            return Category::all();
        });

        return redirect()->route('admin.categories.index')->with('success', 'Category has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        Category::destroy($category->id);

        Cache::forget('categories');
        $categories = Cache::remember('categories', 120, function () {
            return Category::all();
        });

        return redirect()->route('admin.categories.index')->with('success', 'Category has been deleted!');
    }
}
