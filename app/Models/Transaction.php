<?php

namespace App\Models;

use App\Casts\Money;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
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

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Gets the piggybank where the transaction is from
     */
    public function from(): BelongsTo
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

    /**
     * Gets the piggybank where the transaction is going to
     */
    public function getUser(): User
    {
        return $this->category->user;
    }
}
