<?php

namespace Database\Seeders;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (User::all() as $user) {
            $data = [
                Expense::factory()->make(['user_id' => $user->id])->toArray(),
                Expense::factory()->make(['user_id' => $user->id])->toArray(),
            ];

            if ($user->email == 'test@example.com') {
                $piggyBank = $user->piggyBanks()->first()->id;

                $data = [
                    Expense::factory()->make(['name' => 'Sportschool', 'amount' => 2000, 'user_id' => $user->id, 'from_id' => $piggyBank, 'to_id' => $piggyBank])->toArray(),
                    Expense::factory()->make(['name' => 'Telefoon abonnement', 'amount' => 1000, 'user_id' => $user->id, 'from_id' => $piggyBank, 'to_id' => $piggyBank])->toArray(),
                ];
            }

            $user->expense()->insert($data);
        }
    }
}
