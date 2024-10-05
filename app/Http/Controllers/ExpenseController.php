<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Models\Expense;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\ExpenseCategory;
use App\Http\Controllers\Controller;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ExpenseCategory::get();

        // dd($categories);

        return Inertia::render('Expenses/Create', compact(['categories']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseRequest $request)
    {
        // dd($request->all());

        $user = auth()->user();

        $user->expenses()->create([
            'expense_category_id' => $request->category,
            'amount' => $request->amount,
            'entry_date' => $request->entryDate,
        ]);

        $redirectRoute = strtolower($user->getRoleName()) === 'administrator'
            ? 'admin.expenses.index'
            : 'user.expenses.index';

        return to_route($redirectRoute)->with('success', 'Expense added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        $expense = Expense::whereId($expense->id)->with('expenseCategory')->first();
        $categories = ExpenseCategory::get();

        return Inertia::render('Expenses/Edit', compact(['categories', 'expense']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExpenseRequest $request, Expense $expense)
    {
        $this->authorize('update', $expense);

        $user = auth()->user();

        $expense->update([
            'expense_category_id' => $request->category,
            'amount' => $request->amount ?? $expense->amount,
            'entry_date' => $request->entryDate,
        ]);

        $redirectRoute = strtolower($user->getRoleName()) === 'administrator'
            ? 'admin.expenses.index'
            : 'user.expenses.index';

        return to_route($redirectRoute)->with('success', 'Expense updated');
    }

    public function delete(Expense $expense)
    {
        return Inertia::render('Expenses/Delete', compact(['expense']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        $this->authorize('destroy', $expense);

        $user = auth()->user();

        $expense->delete();

        $redirectRoute = strtolower($user->getRoleName()) === 'administrator'
            ? 'admin.expenses.index'
            : 'user.expenses.index';

        return to_route($redirectRoute)->with('success', 'Expense updated');
    }
}
