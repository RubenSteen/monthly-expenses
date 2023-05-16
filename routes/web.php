<?php

use App\Http\Controllers\CollectiveExpenseController;
use App\Http\Controllers\CollectiveSavingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\PiggyBankController;
use App\Http\Controllers\SavingController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('landing');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/income', [IncomeController::class, 'index'])->name('income.index');
    Route::post('/income', [IncomeController::class, 'store'])->name('income.store');
    Route::put('/income/{income}', [IncomeController::class, 'update'])->name('income.update');
    Route::delete('/income/{income}', [IncomeController::class, 'delete'])->name('income.delete');

    Route::get('/piggy-bank', [PiggyBankController::class, 'index'])->name('piggy-bank.index');
    Route::post('/piggy-bank', [PiggyBankController::class, 'store'])->name('piggy-bank.store');
    Route::put('/piggy-bank/{piggyBank}', [PiggyBankController::class, 'update'])->name('piggy-bank.update');
    Route::delete('/piggy-bank/{piggyBank}', [PiggyBankController::class, 'delete'])->name('piggy-bank.delete');

    Route::get('/expense', [ExpenseController::class, 'index'])->name('expense.index');
    Route::post('/expense', [ExpenseController::class, 'store'])->name('expense.store');
    Route::put('/expense/{expense}', [ExpenseController::class, 'update'])->name('expense.update');
    Route::delete('/expense/{expense}', [ExpenseController::class, 'delete'])->name('expense.delete');

    Route::get('/collective-expense', [CollectiveExpenseController::class, 'index'])->name('collective-expense.index');
    Route::post('/collective-expense', [CollectiveExpenseController::class, 'store'])->name('collective-expense.store');
    Route::put('/collective-expense/{collectiveExpense}', [CollectiveExpenseController::class, 'update'])->name('collective-expense.update');
    Route::delete('/collective-expense/{collectiveExpense}', [CollectiveExpenseController::class, 'delete'])->name('collective-expense.delete');

    Route::get('/saving', [SavingController::class, 'index'])->name('saving.index');
    Route::post('/saving', [SavingController::class, 'store'])->name('saving.store');
    Route::put('/saving/{saving}', [SavingController::class, 'update'])->name('saving.update');
    Route::delete('/saving/{saving}', [SavingController::class, 'delete'])->name('saving.delete');

    Route::get('/collective-saving', [CollectiveSavingController::class, 'index'])->name('collective-saving.index');
    Route::post('/collective-saving', [CollectiveSavingController::class, 'store'])->name('collective-saving.store');
    Route::put('/collective-saving/{collectiveSaving}', [CollectiveSavingController::class, 'update'])->name('collective-saving.update');
    Route::delete('/collective-saving/{collectiveSaving}', [CollectiveSavingController::class, 'delete'])->name('collective-saving.delete');

});
