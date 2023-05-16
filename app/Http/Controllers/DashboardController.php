<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $dashboardCards = [
            ['name' => 'Overgehouden budget', 'stat' => calculateLeftoverBudget()],
        ];

        return Inertia::render('Dashboard', [
            'dashboardCards' => $dashboardCards,
            'totalStats' => [
                'income' => moneyDisplay(Auth::user()->total_income_amount),
                'expense' => moneyDisplay(Auth::user()->total_expense_amount),
                'saving' => moneyDisplay(Auth::user()->total_saving_amount),
                'collectiveExpense' => moneyDisplay(Auth::user()->total_collective_expense_amount),
                'collectiveSaving' => moneyDisplay(Auth::user()->total_collective_saving_amount),
            ],
        ]);
    }
}
