<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Models\CollectiveExpense;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CollectiveExpenseController extends Controller
{
    public function index()
    {
        return Inertia::render('CollectiveExpense', [
            'transactions' => Auth::user()->collectiveExpense()
                ->get()
                ->transform(fn ($transaction) => [
                    'id' => $transaction->id,
                    'name' => $transaction->name,
                    'amount' => $transaction->amount,
                    'from' => $transaction->from->only(['id', 'name', 'description']),
                    'to' => $transaction->to->only(['id', 'name', 'description']),
                    // 'from_id' => $transaction->from->id,
                    // 'to_id' => $transaction->to->id,
                ]),
            'piggyBanks' => Auth::user()->piggyBanks()
                ->get()
                ->transform(fn ($piggyBank) => [
                    'id' => $piggyBank->id,
                    'name' => $piggyBank->name,
                ]),
        ]);
    }

    public function store(StoreTransactionRequest $request): RedirectResponse
    {
        Auth::user()->collectiveExpense()->create($request->validated());

        return Redirect::back()->with(['success' => 'Gezamelijke uitgaven aangemaakt']);
    }

    public function update(StoreTransactionRequest $request, CollectiveExpense $collectiveExpense): RedirectResponse
    {
        // Cannot delete a collective expense transaction that isnt theirs
        if (Auth::user()->id !== $collectiveExpense->user_id) {
            return Redirect::back()->with('error', 'Dit is niet jou gezamelijke uitgaven vriend');
        }

        $collectiveExpense->update($request->all());

        return Redirect::back()->with('success', 'Gezamelijke uitgaven aangepast');
    }

    public function delete(CollectiveExpense $collectiveExpense): RedirectResponse
    {
        // Cannot delete a collective expense transaction that isnt theirs
        if (Auth::user()->id !== $collectiveExpense->user_id) {
            return Redirect::back()->with('error', 'Dit is niet jou gezamelijke uitgaven vriend');
        }

        $collectiveExpense->delete();

        return Redirect::back()->with('success', 'Gezamelijke uitgaven verwijderd');
    }
}
