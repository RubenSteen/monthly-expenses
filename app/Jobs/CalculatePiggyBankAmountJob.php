<?php

namespace App\Jobs;

use Brick\Money\Money;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculatePiggyBankAmountJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $from;

    public $to;

    /**
     * Create a new job instance.
     */
    public function __construct(public $transaction)
    {
        $this->transaction = $transaction;

        $this->from = $transaction->from;

        $this->to = $transaction->to;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->updateAmount($this->from, 'from_id');

        $this->updateAmount($this->to, 'to_id');
    }

    /**
     * Gets all the transactions and calculate the total amount.
     */
    public function updateAmount($model, $field): void
    {
        $method = 'minus';

        if ($field == 'to_id') {
            $method = 'plus';
        }

        $budget = Money::of(0, 'EUR');

        foreach ($model->getTransactions($field)->pluck('amount') as $amount) {
            $budget = $budget->$method($amount);
        }

        $model->amount = $budget;
        $model->update();
    }
}
