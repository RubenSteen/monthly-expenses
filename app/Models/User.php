<?php

namespace App\Models;

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
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(function (User $user) {
            $user->last_activity = now();
        });

        static::created(function (User $user) {

            //Create a default PiggyBank if the user does not have one.
            if ($user->piggyBanks()->count() === 0) {
                $user->piggyBanks()->create([
                    'name' => 'Eigen rekening',
                ]);
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password',
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
    public function expense(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    /**
     * Gets the users their saving transactions
     */
    public function savings(): HasMany
    {
        return $this->hasMany(Saving::class);
    }

    /**
     * Gets the users their collective saving transactions
     */
    public function collectiveSaving(): HasMany
    {
        return $this->hasMany(CollectiveSaving::class);
    }

    /**
     * Gets the users their collective expense transactions
     */
    public function collectiveExpense(): HasMany
    {
        return $this->hasMany(CollectiveExpense::class);
    }
}
