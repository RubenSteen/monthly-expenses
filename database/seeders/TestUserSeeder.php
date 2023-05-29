<?php

namespace Database\Seeders;

use App\Models\Income;
use App\Models\User;
use Illuminate\Database\Seeder;

class TestUserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()
            ->superAdmin()
            ->withPersonalTeam()
            ->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);

        $this->createIncome($user);
    }

    public function createIncome($user): void
    {
        $user->income()->create(
            Income::factory()->make([
                'name' => 'Salaris', 'amount' => 1000, 'user_id' => $user->id, 'to_id' => $user->piggyBanks->first()->id,
            ])->toArray()
        );

        $user->income()->create(
            Income::factory()->make([
                'name' => 'Huurtoeslag', 'amount' => 1000, 'user_id' => $user->id, 'to_id' => $user->piggyBanks->first()->id,
            ])->toArray()
        );
    }
}
