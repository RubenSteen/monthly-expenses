<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Jobs\CalculateTransactionTotalAmount;
use App\Models\CollectiveSaving;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CollectiveSavingController extends Controller
{
    public function index()
    {
        return Inertia::render('CollectiveSaving', [
            'transactions' => Auth::user()->collectiveSaving()
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
        Auth::user()->collectiveSaving()->create($request->validated(), correctAmount($request->validated()['amount']));

        CalculateTransactionTotalAmount::dispatch(Auth::user()->collectiveSaving);

        return Redirect::back()->with(['success' => 'Gezamelijke spaardoel aangemaakt']);
    }

    public function update(StoreTransactionRequest $request, CollectiveSaving $collectiveSaving): RedirectResponse
    {
        // Cannot delete a collective saving transaction that isnt theirs
        if (Auth::user()->id !== $collectiveSaving->user_id) {
            return Redirect::back()->with('error', 'Dit is niet jou gezamelijke spaardoel vriend');
        }

        $collectiveSaving->update($request->validated(), correctAmount($request->validated()['amount']));

        CalculateTransactionTotalAmount::dispatch(Auth::user()->collectiveSaving);

        return Redirect::back()->with('success', 'Gezamelijke spaardoel aangepast');
    }

    public function delete(CollectiveSaving $collectiveSaving): RedirectResponse
    {
        // Cannot delete a collective saving transaction that isnt theirs
        if (Auth::user()->id !== $collectiveSaving->user_id) {
            return Redirect::back()->with('error', 'Dit is niet jou gezamelijke spaardoel vriend');
        }

        $collectiveSaving->delete();

        CalculateTransactionTotalAmount::dispatch(Auth::user()->collectiveSaving);

        return Redirect::back()->with('success', 'Gezamelijke spaardoel verwijderd');
    }
}
