<?php

namespace App\Observers;

use App\Jobs\CalculateCategoryAmountJob;
use App\Models\Transaction;

class TransactionObserver
{
    /**
     * Handle the Transaction "created" event.
     */
    public function created(Transaction $transaction): void
    {
        CalculateCategoryAmountJob::dispatch($transaction->category);
    }

    /**
     * Handle the Transaction "updated" event.
     */
    public function updated(Transaction $transaction): void
    {
        CalculateCategoryAmountJob::dispatch($transaction->category);
    }

    /**
     * Handle the Transaction "deleted" event.
     */
    public function deleted(Transaction $transaction): void
    {
        CalculateCategoryAmountJob::dispatch($transaction->category);
    }

    /**
     * Handle the Transaction "restored" event.
     */
    public function restored(Transaction $transaction): void
    {
        CalculateCategoryAmountJob::dispatch($transaction->category);
    }

    /**
     * Handle the Transaction "force deleted" event.
     */
    public function forceDeleted(Transaction $transaction): void
    {
        CalculateCategoryAmountJob::dispatch($transaction->category);
    }
}
