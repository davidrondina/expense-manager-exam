<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExpenseCategoryRequest;
use App\Http\Requests\UpdateExpenseCategoryRequest;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExpenseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = ExpenseCategory::get();

        // dd($roles);

        return Inertia::render('Admin/ExpenseCategories/Index', compact(['categories']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/ExpenseCategories/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseCategoryRequest $request)
    {
        ExpenseCategory::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return to_route('admin.categories.index')->with('success', 'Category added.');
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
    public function edit(ExpenseCategory $category)
    {
        return Inertia::render('Admin/ExpenseCategories/Edit', compact(['category']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExpenseCategoryRequest $request, ExpenseCategory $category)
    {
        $category->update([
            'name' => $request->name ?? $category->name,
            'description' => $request->description ?? $category->description
        ]);

        return to_route('admin.categories.index')->with('success', 'Role updated.');
    }

    public function delete(ExpenseCategory $category)
    {
        return Inertia::render('Admin/ExpenseCategories/Delete', compact(['category']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExpenseCategory $category)
    {
        $category->delete();

        return to_route('admin.categories.index')->with('success', 'Category deleted.');
    }
}
