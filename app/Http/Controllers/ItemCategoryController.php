<?php

namespace App\Http\Controllers;

use App\Models\ItemCategory;
use Illuminate\Http\Request;

class ItemCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = ItemCategory::query()
            ->withCount('items')
            ->orderBy('id', 'asc')
            ->get();

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => ['required', 'string', 'max:100'],
                'division' => ['required', 'string', 'max:100'],
            ],
            [
                'name.required' => 'The name field is required.',
                'division.required' => 'The division pj field is required.',
            ]
        );

        ItemCategory::create($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemCategory $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ItemCategory $category)
    {
        $validated = $request->validate(
            [
                'name' => ['required', 'string', 'max:100'],
                'division' => ['required', 'string', 'max:100'],
            ],
            [
                'name.required' => 'The name field is required.',
                'division.required' => 'The division pj field is required.',
            ]
        );

        $category->update($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemCategory $category)
    {
        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
