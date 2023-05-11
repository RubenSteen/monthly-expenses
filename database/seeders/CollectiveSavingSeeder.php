<?php

namespace Database\Seeders;

use App\Models\CollectiveSaving;
use App\Models\User;
use Illuminate\Database\Seeder;

class CollectiveSavingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (User::all() as $user) {
            $data = [
                CollectiveSaving::factory()->make(['user_id' => $user->id])->toArray(),
                CollectiveSaving::factory()->make(['user_id' => $user->id])->toArray(),
            ];

            if ($user->email == 'test@example.com') {
                $piggyBank = $user->piggyBanks()->first()->id;

                $data = [
                    CollectiveSaving::factory()->make(['name' => 'Auto', 'amount' => 2000, 'user_id' => $user->id, 'from_id' => $piggyBank, 'to_id' => $piggyBank])->toArray(),
                    CollectiveSaving::factory()->make(['name' => 'Huis kopen', 'amount' => 1000, 'user_id' => $user->id, 'from_id' => $piggyBank, 'to_id' => $piggyBank])->toArray(),
                ];
            }

            $user->collectiveSaving()->insert($data);
        }
    }
}
