<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Jobs\CalculateTransactionTotalAmount;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TestUserSeeder::class,
        ]);

        // Correcting the income and transaction data once all users, income and transactions are created
        foreach (User::all() as $user) {
            CalculateTransactionTotalAmount::dispatch($user->income);
        }
    }
}
