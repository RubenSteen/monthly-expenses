<?php

namespace App\Observers;

use App\Models\Income;
use App\Models\PiggyBank;
use App\Models\Transaction;

class PiggyBankObserver
{
    /**
     * Handle the Category "deleting" event.
     */
    public function deleting(PiggyBank $piggyBank): void
    {
        foreach (Income::where('to_id', $piggyBank->id)->get() as $object) {
            $object->delete();
        }

        foreach (Transaction::where('from_id', $piggyBank->id)->orWhere('to_id', $piggyBank->id)->get() as $object) {
            $object->delete();
        }
    }
}
