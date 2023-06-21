<?php

namespace App\Models;

use App\Casts\Money;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'total_income_amount',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'total_income_amount' => Money::class,
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function isAdmin()
    {
        return $this->admin != null ? true : false;
    }

    public function isSuperAdmin()
    {
        return $this->super_admin != null ? true : false;
    }

    /**
     * Gets the users their piggy banks
     */
    public function piggyBanks(): HasMany
    {
        return $this->hasMany(PiggyBank::class);
    }

    /**
     * Gets the users their income transactions
     */
    public function income(): HasMany
    {
        return $this->hasMany(Income::class);
    }

    /**
     * Gets the users their expense transactions
     */
    public function category(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Gets the all the transactions that the user has over all categories
     */
    public function getTransactions()
    {
        return Transaction::whereIn('category_id', $this->category->pluck('id'))->get();
    }
}
