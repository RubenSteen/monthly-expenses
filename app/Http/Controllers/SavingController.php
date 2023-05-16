<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Jobs\CalculateTransactionTotalAmount;
use App\Models\Saving;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class SavingController extends Controller
{
    public function index()
    {
        return Inertia::render('Saving', [
            'transactions' => Auth::user()->savings()
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
        Auth::user()->savings()->create($request->validated(), correctAmount($request->validated()['amount']));

        CalculateTransactionTotalAmount::dispatch(Auth::user()->savings);

        return Redirect::back()->with(['success' => 'Spaardoel aangemaakt']);
    }

    public function update(StoreTransactionRequest $request, Saving $saving): RedirectResponse
    {
        // Cannot delete a saving transaction that isnt theirs
        if (Auth::user()->id !== $saving->user_id) {
            return Redirect::back()->with('error', 'Dit is niet jou spaardoel vriend');
        }

        $saving->update($request->validated(), correctAmount($request->validated()['amount']));

        CalculateTransactionTotalAmount::dispatch(Auth::user()->savings);

        return Redirect::back()->with('success', 'Spaardoel aangepast');
    }

    public function delete(Saving $saving): RedirectResponse
    {
        // Cannot delete a saving transaction that isnt theirs
        if (Auth::user()->id !== $saving->user_id) {
            return Redirect::back()->with('error', 'Dit is niet jou spaardoel vriend');
        }

        $saving->delete();

        CalculateTransactionTotalAmount::dispatch($saving->all(), $saving->user, $saving->getTotalField());

        return Redirect::back()->with('success', 'Spaardoel verwijderd');
    }
}
