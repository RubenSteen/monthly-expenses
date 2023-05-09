<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Income', [
            'transactions' => Auth::user()->income()
                ->get()
                ->transform(fn ($transaction) => [
                    'id' => $transaction->id,
                    'name' => $transaction->name,
                    'amount' => $transaction->description,
                    'from' => '€25,57',
                    'to' => 2,
                ]),
        ]);
    }
}
