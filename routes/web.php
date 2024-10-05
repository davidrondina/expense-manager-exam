<?php

use App\Http\Controllers\DashboardController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ExpenseCategoryController;
use App\Http\Controllers\User\ExpenseController as USExpenseController;
use App\Http\Controllers\Admin\ExpenseController as ADExpenseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('auth.admin')->prefix('admin')->as('admin.')->group(function () {
        Route::prefix('users')->as('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::get('/{user}', [UserController::class, 'edit'])->name('edit');
            Route::put('/{user}', [UserController::class, 'update'])->name('update');
            Route::get('/delete/{user}', [UserController::class, 'delete'])->name('delete');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('roles')->as('roles.')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('index');
            Route::post('/', [RoleController::class, 'store'])->name('store');
            Route::get('/create', [RoleController::class, 'create'])->name('create');
            Route::get('/{role}', [RoleController::class, 'edit'])->name('edit');
            Route::put('/{role}', [RoleController::class, 'update'])->name('update');
            Route::get('/delete/{role}', [RoleController::class, 'delete'])->name('delete');
            Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('categories')->as('categories.')->group(function () {
            Route::get('/', [ExpenseCategoryController::class, 'index'])->name('index');
            Route::post('/', [ExpenseCategoryController::class, 'store'])->name('store');
            Route::get('/create', [ExpenseCategoryController::class, 'create'])->name('create');
            Route::get('/{category}', [ExpenseCategoryController::class, 'edit'])->name('edit');
            Route::put('/{category}', [ExpenseCategoryController::class, 'update'])->name('update');
            Route::get('/delete/{category}', [ExpenseCategoryController::class, 'delete'])->name('delete');
            Route::delete('/{category}', [ExpenseCategoryController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('expenses')->as('expenses.')->group(function () {
            Route::get('/', [ADExpenseController::class, 'index'])->name('index');
        });
    });

    Route::prefix('user')->as('user.')->group(function () {
        Route::prefix('expenses')->as('expenses.')->group(function () {
            Route::get('/', [USExpenseController::class, 'index'])->name('index');
        });
    });

    Route::prefix('expenses')->as('expenses.')->group(function () {
        Route::post('/', [ExpenseController::class, 'store'])->name('store');
        Route::get('/create', [ExpenseController::class, 'create'])->name('create');
        Route::get('/{expense}', [ExpenseController::class, 'edit'])->name('edit');
        Route::put('/{expense}', [ExpenseController::class, 'update'])->name('update');
        Route::get('/delete/{expense}', [ExpenseController::class, 'delete'])->name('delete');
        Route::delete('/{expense}', [ExpenseController::class, 'destroy'])->name('destroy');
    });
});

Route::get('/test', function () {
    return Inertia::render('Test');
});

require __DIR__ . '/auth.php';
