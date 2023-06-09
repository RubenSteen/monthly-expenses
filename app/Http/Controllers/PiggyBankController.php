<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePiggyBankRequest;
use App\Models\PiggyBank;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PiggyBankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('PiggyBank', [
            'piggyBanks' => Auth::user()->piggyBanks()
                ->get()
                ->transform(fn ($piggyBank) => [
                    'id' => $piggyBank->id,
                    'name' => $piggyBank->name,
                    'description' => $piggyBank->description,
                    'amount' => money($piggyBank->amount),
                    'transactions_count' => Transaction::where('from_id', $piggyBank->id)->orWhere('to_id', $piggyBank->id)->count(),
                ]),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePiggyBankRequest $request): RedirectResponse
    {
        Auth::user()->piggyBanks()->create($request->all());

        return Redirect::route('piggy-bank.index')->with(['success' => 'Potje aangemaakt']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePiggyBankRequest $request, PiggyBank $piggyBank): RedirectResponse
    {
        // Cannot edit a piggy bank that isnt theirs
        if (Auth::user()->id !== $piggyBank->user_id) {
            return abort(403);
        }

        $piggyBank->update($request->all());

        return Redirect::back()->with('success', 'Potje aangepast');
    }

    public function delete(PiggyBank $piggyBank): RedirectResponse
    {
        // Cannot delete a piggy bank that isnt theirs
        if (Auth::user()->id !== $piggyBank->user_id) {
            return abort(403);
        }

        $piggyBank->delete();

        return Redirect::back()->with('success', 'Potje verwijderd');
    }
}
