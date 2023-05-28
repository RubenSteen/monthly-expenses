<?php

namespace App\Observers;

use App\Jobs\CalculateCategoryAmountJob;
use App\Jobs\CalculatePiggyBankAmountJob;
use App\Models\Transaction;

class TransactionObserver
{
    /**
     * Handle the Transaction "created" event.
     */
    public function created(Transaction $transaction): void
    {
        CalculateCategoryAmountJob::dispatch($transaction->category);
        CalculatePiggyBankAmountJob::dispatch($transaction);
    }

    /**
     * Handle the Transaction "updated" event.
     */
    public function updated(Transaction $transaction): void
    {
        // Only run the job if the amount value changed
        if ($transaction->amount->getMinorAmount()->toInt() !== $transaction->getOriginal('amount')->getMinorAmount()->toInt()) {
            CalculateCategoryAmountJob::dispatch($transaction->category);
        }

        // Only run the job if the to_id or from_id value changed
        if ($transaction->to_id !== $transaction->getOriginal('to_id') || $transaction->from_id !== $transaction->getOriginal('from_id')) {
            CalculatePiggyBankAmountJob::dispatch($transaction);
        }
    }

    /**
     * Handle the Transaction "deleted" event.
     */
    public function deleted(Transaction $transaction): void
    {
        CalculateCategoryAmountJob::dispatch($transaction->category);
        CalculatePiggyBankAmountJob::dispatch($transaction);
    }

    /**
     * Handle the Transaction "restored" event.
     */
    public function restored(Transaction $transaction): void
    {
        CalculateCategoryAmountJob::dispatch($transaction->category);
        CalculatePiggyBankAmountJob::dispatch($transaction);
    }

    /**
     * Handle the Transaction "force deleted" event.
     */
    public function forceDeleted(Transaction $transaction): void
    {
        CalculateCategoryAmountJob::dispatch($transaction->category);
        CalculatePiggyBankAmountJob::dispatch($transaction);
    }
}
