<?php

namespace App\Jobs;

use Brick\Money\Money;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class CalculateCategoryAmountJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    public $category;

    /**
     * Create a new job instance.
     */
    public function __construct(public $transaction)
    {
        $this->category = $transaction->category;

        $this->transaction = $transaction;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $budget = Money::of(0, 'EUR');

        foreach ($this->category->transaction->pluck('amount') as $amount) {
            $budget = $budget->plus($amount);
        }

        $this->category->amount = $budget;
        $this->category->update();
    }
}
