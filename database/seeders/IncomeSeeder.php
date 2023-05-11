<?php

namespace Database\Seeders;

use App\Models\Income;
use App\Models\User;
use Illuminate\Database\Seeder;

class IncomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (User::all() as $user) {
            $data = [
                Income::factory()->make(['user_id' => $user->id])->toArray(),
                Income::factory()->make(['user_id' => $user->id])->toArray(),
            ];

            if ($user->email == 'test@example.com') {
                $piggyBank = $user->piggyBanks()->first()->id;

                $data = [
                    Income::factory()->make(['name' => 'Salaris', 'amount' => 2000, 'user_id' => $user->id, 'from_id' => $piggyBank, 'to_id' => $piggyBank])->toArray(),
                    Income::factory()->make(['name' => 'Huurtoeslag', 'amount' => 1000, 'user_id' => $user->id, 'from_id' => $piggyBank, 'to_id' => $piggyBank])->toArray(),
                ];
            }

            $user->income()->insert($data);
        }
    }
}
