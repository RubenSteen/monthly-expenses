<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class TransactionController extends Controller
{
    public function store(StoreTransactionRequest $request, Category $category): RedirectResponse
    {
        $category->transaction()->create(array_merge($request->validated(), correctAmount($request->validated()['amount'])));

        return Redirect::back()->with(['success' => 'Transactie aangemaakt']);
    }

    public function update(UpdateTransactionRequest $request, Transaction $transaction): RedirectResponse
    {
        $transaction->update(array_merge($request->validated(), correctAmount($request->validated()['amount'])));

        return Redirect::back()->with('success', 'Transactie aangepast');
    }

    public function delete(Transaction $transaction): RedirectResponse
    {
        if (Auth::user()->id !== $transaction->getUser()->id) {
            return abort(403);
        }

        $transaction->delete();

        return Redirect::back()->with('success', 'Transactie verwijderd');
    }
}
