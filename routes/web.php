<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UserController as AdminUser;
use App\Http\Controllers\Admin\ExpenseController as AdminExpense;
use App\Http\Controllers\Admin\CategoryController as AdminCategory;
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\User\ExpenseController as UserExpense;
use App\Http\Controllers\User\CategoryController as UserCategory;
use App\Http\Controllers\User\ReportController as UserReport;

Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    }
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login',    [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login',   [LoginController::class, 'login'])->name('login.post');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register',[RegisterController::class, 'register'])->name('register.post');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::get('/users',               [AdminUser::class, 'index'])->name('users.index');
    Route::get('/users/{user}',        [AdminUser::class, 'show'])->name('users.show');
    Route::post('/users/{user}/toggle',[AdminUser::class, 'toggleStatus'])->name('users.toggle');
    Route::delete('/users/{user}',     [AdminUser::class, 'destroy'])->name('users.destroy');
    Route::get('/expenses',               [AdminExpense::class, 'index'])->name('expenses.index');
    Route::delete('/expenses/{expense}',  [AdminExpense::class, 'destroy'])->name('expenses.destroy');
    Route::get('/categories',              [AdminCategory::class, 'index'])->name('categories.index');
    Route::post('/categories',             [AdminCategory::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}',   [AdminCategory::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}',[AdminCategory::class, 'destroy'])->name('categories.destroy');
});

Route::middleware(['auth', 'user.role'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboard::class, 'index'])->name('dashboard');
    Route::get('/expenses',               [UserExpense::class, 'index'])->name('expenses.index');
    Route::get('/expenses/create',        [UserExpense::class, 'create'])->name('expenses.create');
    Route::post('/expenses',              [UserExpense::class, 'store'])->name('expenses.store');
    Route::get('/expenses/{expense}/edit',[UserExpense::class, 'edit'])->name('expenses.edit');
    Route::put('/expenses/{expense}',     [UserExpense::class, 'update'])->name('expenses.update');
    Route::delete('/expenses/{expense}',  [UserExpense::class, 'destroy'])->name('expenses.destroy');
    Route::get('/categories',              [UserCategory::class, 'index'])->name('categories.index');
    Route::post('/categories',             [UserCategory::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}',   [UserCategory::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}',[UserCategory::class, 'destroy'])->name('categories.destroy');
    Route::get('/reports',     [UserReport::class, 'index'])->name('reports.index');
    Route::get('/reports/pdf', [UserReport::class, 'exportPdf'])->name('reports.pdf');
    Route::get('/reports/csv', [UserReport::class, 'exportCsv'])->name('reports.csv');
});
