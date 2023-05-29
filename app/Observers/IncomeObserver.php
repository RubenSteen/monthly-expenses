<?php

namespace App\Observers;

use App\Jobs\CalculatePiggyBankAmountJob;
use App\Models\Income;

class IncomeObserver
{
    /**
     * Handle the Income "created" event.
     */
    public function created(Income $income): void
    {
        CalculatePiggyBankAmountJob::dispatch($income->user);
    }

    /**
     * Handle the Income "updated" event.
     */
    public function updated(Income $income): void
    {
        CalculatePiggyBankAmountJob::dispatch($income->user);
    }

    /**
     * Handle the Income "deleted" event.
     */
    public function deleted(Income $income): void
    {
        CalculatePiggyBankAmountJob::dispatch($income->user);
    }

    /**
     * Handle the Income "restored" event.
     */
    public function restored(Income $income): void
    {
        CalculatePiggyBankAmountJob::dispatch($income->user);
    }

    /**
     * Handle the Income "force deleted" event.
     */
    public function forceDeleted(Income $income): void
    {
        CalculatePiggyBankAmountJob::dispatch($income->user);
    }
}
