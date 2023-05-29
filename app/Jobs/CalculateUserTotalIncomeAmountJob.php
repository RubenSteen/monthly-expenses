<?php

namespace App\Jobs;

use Brick\Money\Money;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculateUserTotalIncomeAmountJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $budget = Money::of(0, 'EUR');

        foreach ($this->user->income->pluck('amount') as $amount) {
            $budget = $budget->plus($amount);
        }

        $this->user->update(['total_income_amount' => $budget]);
    }
}
