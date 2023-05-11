<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            // PiggyBankSeeder::class,
            // IncomeSeeder::class,
            // ExpenseSeeder::class,
            // CollectiveExpenseSeeder::class,
            // SavingSeeder::class,
            // CollectiveSavingSeeder::class,
        ]);
    }
}
