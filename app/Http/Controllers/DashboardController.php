<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Expense;
use Illuminate\Http\Request;
use App\Models\ExpenseCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $expenseCategories = ExpenseCategory::get()->pluck(['name'])->toArray();

        $expensesByCategory = Expense::select('expense_category_id', DB::raw('SUM(amount) as total_amount'))
            ->where('user_id', $user->id)
            ->groupBy('expense_category_id')
            ->with(relations: 'expenseCategory') // To load the related category
            ->get();

        $categoriesWithExpenseSum = ExpenseCategory::with('expenses')
            ->select('expense_categories.id', 'expense_categories.name')
            ->leftJoin('expenses', 'expense_categories.id', '=', 'expenses.expense_category_id')
            ->where('expenses.user_id', $user->id) // assuming $userId is the ID of the user
            ->groupBy('expense_categories.id', 'expense_categories.name')
            ->selectRaw('SUM(expenses.amount) as total_expense')
            ->get();

        $totalExpensesByCategory = [];

        foreach ($expensesByCategory as $expense) {
            array_push($totalExpensesByCategory, $expense->total_amount);
        }

        // dd($expenseCategories, $expensesByCategory, $totalExpensesByCategory, $categoriesWithExpenseSum);

        return Inertia::render('Dashboard', compact(['expenseCategories', 'expensesByCategory', 'totalExpensesByCategory']));
    }
}
