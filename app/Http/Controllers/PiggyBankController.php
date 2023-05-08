<?php

namespace App\Http\Controllers;

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
    public function store(Request $request)
    {
        $user = Auth::user();

        $user->piggyBanks()->create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return Redirect::route('piggy-bank.index')->with(['success' => 'Potje aangemaakt']);
    }
}
