<?php

namespace App\Jobs;

use Brick\Money\Money;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculateTransactionTotalAmount implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;

    public $field;

    /**
     * Create a new job instance.
     */
    public function __construct(public $model)
    {
        $this->model = $model;

        $this->user = $model->first()->user;

        $this->field = $model->first()->getTotalField();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $budget = Money::of(0, 'EUR');

        foreach ($this->model->pluck('amount') as $amount) {
            $budget = $budget->plus($amount);
        }

        $this->user->update([$this->field => $budget]);

        // dd($this->model, $this->user, $this->field, $budget);
    }
}
