<?php

namespace App\Jobs;

use App\Models\Income;
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
        foreach ($this->user->piggyBanks as $piggyBank) {
            $budget = Money::of(0, 'EUR');

            foreach (Income::where('to_id', $piggyBank->id)->get() as $transaction) {
                $budget = $budget->plus($transaction->amount);
            }

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
