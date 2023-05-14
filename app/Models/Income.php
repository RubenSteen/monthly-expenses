<?php

namespace App\Models;

use App\Casts\Money;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'amount',
        'from_id',
        'to_id',
    ];

    protected $casts = [
        'amount' => Money::class,
    ];

    /**
     * Gets the piggybank where the transaction is coming from
     */
    public function from()
    {
        return $this->belongsTo(PiggyBank::class);
    }

    /**
     * Gets the piggybank where the transaction is going to
     */
    public function to(): BelongsTo
    {
        return $this->belongsTo(PiggyBank::class);
    }
}
