<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class TransactionController extends Controller
{
    public function store(StoreTransactionRequest $request, Category $category): RedirectResponse
    {
        $category->transaction()->create($request->validated());

        return Redirect::back()->with(['success' => 'Transactie aangemaakt']);
    }

    // public function update(UpdateTransactionRequest $request, Category $category): RedirectResponse
    // {
    //     $category->update($request->validated());

    //     return Redirect::back()->with('success', 'Categorie aangepast');
    // }

    // public function delete(Category $category): RedirectResponse
    // {
    //     if (Auth::user()->id !== $category->user_id) {
    //         return abort(403);
    //     }

    //     $category->delete();

    //     return Redirect::back()->with('success', 'Categorie verwijderd');
    // }
}
