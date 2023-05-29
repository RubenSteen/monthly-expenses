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
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $empty;

    /**
     * Create a new job instance.
     */
    public function __construct(public $model, public $user = null, public $field = null)
    {
        $this->model = $model;

        $this->empty = is_null($model->first->exists()) ? true : false;

        $this->user = is_null($user) ? $model->first()->user : $this->user;

        $this->field = is_null($field) ? $model->first()->getTotalField() : $this->field;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $budget = Money::of(0, 'EUR');
        if (! $this->empty) {
            foreach ($this->model->pluck('amount') as $amount) {
                $budget = $budget->plus($amount);
            }
        }

        $this->user->update([$this->field => $budget]);
    }
}
