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
        'to_id',
    ];

    protected $casts = [
        'amount' => Money::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getTotalField(): string
    {
        return 'total_income_amount';
    }

    /**
     * Gets the piggybank where the transaction is going to
     */
    public function to(): BelongsTo
    {
        return $this->belongsTo(PiggyBank::class);
    }
}
