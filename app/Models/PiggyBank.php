<?php

namespace App\Models;

use App\Casts\Money;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PiggyBank extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'description',
    ];

    protected $casts = [
        'amount' => Money::class,
    ];

    /**
     * Gets the all the from or to transactions that the piggy bank has
     */
    public function getTransactions(string $field)
    {
        return $this->hasMany(Transaction::class, $field)->get();
    }
}
