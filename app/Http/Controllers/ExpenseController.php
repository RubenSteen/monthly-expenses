<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Jobs\CalculateTransactionTotalAmount;
use App\Models\Expense;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ExpenseController extends Controller
{
    public function index()
    {
        return Inertia::render('Expense', [
            'transactions' => Auth::user()->expense()
                ->get()
                ->transform(fn ($transaction) => [
                    'id' => $transaction->id,
                    'name' => $transaction->name,
                    'amount' => money($transaction->amount),
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
        Auth::user()->expense()->create($request->validated(), correctAmount($request->validated()['amount']));

        CalculateTransactionTotalAmount::dispatch(Auth::user()->expense);

        return Redirect::back()->with(['success' => 'Inkomen aangemaakt']);
    }

    public function update(StoreTransactionRequest $request, Expense $expense): RedirectResponse
    {
        // Cannot delete a expense transaction that isnt theirs
        if (Auth::user()->id !== $expense->user_id) {
            return Redirect::back()->with('error', 'Dit is niet jou uitgaven vriend');
        }

        $expense->update($request->validated(), correctAmount($request->validated()['amount']));

        CalculateTransactionTotalAmount::dispatch(Auth::user()->expense);

        return Redirect::back()->with('success', 'Inkomen aangepast');
    }

    public function delete(Expense $expense): RedirectResponse
    {
        // Cannot delete a expense transaction that isnt theirs
        if (Auth::user()->id !== $expense->user_id) {
            return Redirect::back()->with('error', 'Dit is niet jou uitgaven vriend');
        }

        $expense->delete();

        CalculateTransactionTotalAmount::dispatch(Auth::user()->expense);

        return Redirect::back()->with('success', 'Inkomen verwijderd');
    }
}
