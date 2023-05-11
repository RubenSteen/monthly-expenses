<?php

namespace Database\Seeders;

use App\Models\CollectiveExpense;
use App\Models\User;
use Illuminate\Database\Seeder;

class CollectiveExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (User::all() as $user) {
            $data = [
                CollectiveExpense::factory()->make(['user_id' => $user->id])->toArray(),
                CollectiveExpense::factory()->make(['user_id' => $user->id])->toArray(),
            ];

            if ($user->email == 'test@example.com') {
                $piggyBank = $user->piggyBanks()->first()->id;

                $data = [
                    CollectiveExpense::factory()->make(['name' => 'Netflix', 'amount' => 2000, 'user_id' => $user->id, 'from_id' => $piggyBank, 'to_id' => $piggyBank])->toArray(),
                    CollectiveExpense::factory()->make(['name' => 'Boodschappen', 'amount' => 1000, 'user_id' => $user->id, 'from_id' => $piggyBank, 'to_id' => $piggyBank])->toArray(),
                ];
            }

            $user->collectiveExpense()->insert($data);
        }
    }
}
