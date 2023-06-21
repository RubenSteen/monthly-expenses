<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Income;
use App\Models\PiggyBank;
use App\Models\Transaction;
use App\Models\User;
use App\Observers\CategoryObserver;
use App\Observers\IncomeObserver;
use App\Observers\PiggyBankObserver;
use App\Observers\TransactionObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        PiggyBank::observe(PiggyBankObserver::class);
        Income::observe(IncomeObserver::class);
        Category::observe(CategoryObserver::class);
        Transaction::observe(TransactionObserver::class);
        User::observe(UserObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
