<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'amount',
    ];

    /**
     * Get the parent commentable model.
     */
    public function transactionable(): MorphTo
    {
        return $this->morphTo();
    }
}
