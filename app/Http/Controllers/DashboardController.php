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
            ],
        ]);
    }
}
