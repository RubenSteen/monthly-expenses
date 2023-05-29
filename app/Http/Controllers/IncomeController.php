<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIncomeRequest;
use App\Models\Income;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class IncomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Income', [
            'transactions' => Auth::user()->income()
                ->get()
                ->transform(fn ($transaction) => [
                    'id' => $transaction->id,
                    'name' => $transaction->name,
                    'amount' => money($transaction->amount),
                    'to' => $transaction->to->only(['id', 'name', 'description']),
                ]),
            'piggyBanks' => Auth::user()->piggyBanks()
                ->get()
                ->transform(fn ($piggyBank) => [
                    'id' => $piggyBank->id,
                    'name' => $piggyBank->name,
                ]),
        ]);
    }

    public function store(StoreIncomeRequest $request): RedirectResponse
    {
        Auth::user()->income()->create($request->validated(), correctAmount($request->validated()['amount']));

        return Redirect::back()->with(['success' => 'Inkomen aangemaakt']);
    }

    public function update(StoreIncomeRequest $request, Income $income): RedirectResponse
    {
        // Cannot delete a income transaction that isnt theirs
        if (Auth::user()->id !== $income->user_id) {
            return Redirect::back()->with('error', 'Dit is niet jou inkomen vriend');
        }

        $income->update(array_merge($request->validated(), correctAmount($request->validated()['amount'])));

        return Redirect::back()->with('success', 'Inkomen aangepast');
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
