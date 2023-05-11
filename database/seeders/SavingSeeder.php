<?php

namespace Database\Seeders;

use App\Models\Saving;
use App\Models\User;
use Illuminate\Database\Seeder;

class SavingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (User::all() as $user) {
            $data = [
                Saving::factory()->make(['user_id' => $user->id])->toArray(),
                Saving::factory()->make(['user_id' => $user->id])->toArray(),
            ];

            if ($user->email == 'test@example.com') {
                $piggyBank = $user->piggyBanks()->first()->id;

                $data = [
                    Saving::factory()->make(['name' => 'Kleren', 'amount' => 2000, 'user_id' => $user->id, 'from_id' => $piggyBank, 'to_id' => $piggyBank])->toArray(),
                    Saving::factory()->make(['name' => 'Laptop', 'amount' => 1000, 'user_id' => $user->id, 'from_id' => $piggyBank, 'to_id' => $piggyBank])->toArray(),
                ];
            }

            $user->savings()->insert($data);
        }
    }
}
