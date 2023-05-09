<?php

use App\Http\Controllers\IncomeController;
use App\Http\Controllers\PiggyBankController;
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

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/income', [IncomeController::class, 'index'])->name('income.index');
    Route::post('/income', [IncomeController::class, 'store'])->name('income.store');
    Route::put('/income/{income}', [IncomeController::class, 'update'])->name('income.update');
    Route::delete('/income/{income}', [IncomeController::class, 'delete'])->name('income.delete');

    Route::get('/piggy-bank', [PiggyBankController::class, 'index'])->name('piggy-bank.index');
    Route::post('/piggy-bank', [PiggyBankController::class, 'store'])->name('piggy-bank.store');
    Route::put('/piggy-bank/{piggyBank}', [PiggyBankController::class, 'update'])->name('piggy-bank.update');
    Route::delete('/piggy-bank/{piggyBank}', [PiggyBankController::class, 'delete'])->name('piggy-bank.delete');

    Route::get('/expenses', function () {
        return Inertia::render('Expenses');
    })->name('expenses.index');

    Route::get('/collective-expenses', function () {
        return Inertia::render('CollectiveExpenses');
    })->name('collective-expenses.index');

    Route::get('/savings', function () {
        return Inertia::render('Savings');
    })->name('savings.index');

    Route::get('/collective-savings', function () {
        return Inertia::render('CollectiveSavings');
    })->name('collective-savings.index');

});
