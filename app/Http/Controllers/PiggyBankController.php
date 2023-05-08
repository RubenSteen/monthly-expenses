<?php

namespace App\Http\Controllers;

use App\Models\PiggyBank;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        return Inertia::render('PiggyBank');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        Auth::user()->piggyBanks()->create($validated);

        return Redirect::route('piggy-bank.index')->with(['success' => 'Potje aangemaakt']);
    }

    public function delete(PiggyBank $piggyBank): RedirectResponse
    {
        // Cannot delete a piggy bank that isnt theirs
        if (Auth::user()->id !== $piggyBank->user_id) {
            return Redirect::back()->with('error', 'Dit is niet jou potje vriend');
        }

        $piggyBank->delete();

        return Redirect::back()->with('success', 'Potje verwijderd');
    }
}
