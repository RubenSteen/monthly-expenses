<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Models\Income;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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

    public function store(StoreTransactionRequest $request): RedirectResponse
    {
        Auth::user()->income()->create($request->all());

        return Redirect::route('piggy-bank.index')->with(['success' => 'Inkomen aangemaakt']);
    }

    public function delete(Income $income): RedirectResponse
    {
        // Cannot delete a income transaction that isnt theirs
        if (Auth::user()->id !== $income->user_id) {
            return Redirect::back()->with('error', 'Dit is niet jou inkomen vriend');
        }

        $income->delete();

        return Redirect::back()->with('success', 'Inkomen verwijderd');
    }
}
