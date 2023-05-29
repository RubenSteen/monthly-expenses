<?php

namespace App\Jobs;

use App\Models\Transaction;
use Brick\Money\Money;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculatePiggyBankAmountJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $piggyBanks;

    /**
     * Create a new job instance.
     */
    public function __construct(public $transaction)
    {
        $this->transaction = $transaction;

        $this->piggyBanks = $transaction->category->user->piggyBanks;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->piggyBanks as $piggyBank) {
            $budget = Money::of(0, 'EUR');

            foreach (Transaction::where('from_id', $piggyBank->id)->orWhere('to_id', $piggyBank->id)->get() as $transaction) {
                $method = 'minus';

                if ($transaction->to_id == $piggyBank->id) {
                    $method = 'plus';
                }

                $budget = $budget->$method($transaction->amount);
            }

            $piggyBank->amount = $budget;
            $piggyBank->update();
        }
    }
}
