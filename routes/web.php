<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\PiggyBankController;
use App\Http\Controllers\TransactionController;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
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

    Route::get('/category', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/category', [CategoryController::class, 'store'])->name('category.store')->middleware([HandlePrecognitiveRequests::class]);
    Route::get('/category/{category}', [CategoryController::class, 'show'])->name('category.show');
    Route::put('/category/{category}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/{category}', [CategoryController::class, 'delete'])->name('category.delete');

    Route::post('/transaction/{category}', [TransactionController::class, 'store'])->name('transaction.store');
    Route::put('/transaction/{transaction}', [TransactionController::class, 'update'])->name('transaction.update');
    Route::delete('/transaction/{transaction}', [TransactionController::class, 'delete'])->name('transaction.delete');

    Route::get('/income', [IncomeController::class, 'index'])->name('income.index');
    Route::post('/income', [IncomeController::class, 'store'])->name('income.store');
    Route::put('/income/{income}', [IncomeController::class, 'update'])->name('income.update');
    Route::delete('/income/{income}', [IncomeController::class, 'delete'])->name('income.delete');

    Route::get('/piggy-bank', [PiggyBankController::class, 'index'])->name('piggy-bank.index');
    Route::post('/piggy-bank', [PiggyBankController::class, 'store'])->name('piggy-bank.store');
    Route::put('/piggy-bank/{piggyBank}', [PiggyBankController::class, 'update'])->name('piggy-bank.update');
    Route::delete('/piggy-bank/{piggyBank}', [PiggyBankController::class, 'delete'])->name('piggy-bank.delete');

    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/user', [UserController::class, 'index'])->name('user.index');
    });
});
