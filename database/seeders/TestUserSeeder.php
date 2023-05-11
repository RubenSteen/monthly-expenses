<?php

namespace Database\Seeders;

use App\Models\CollectiveExpense;
use App\Models\CollectiveSaving;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Saving;
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
        $this->createExpense($user);
        $this->createSaving($user);
        $this->createCollectiveExpense($user);
        $this->createCollectiveSaving($user);
    }

    public function createIncome($user): void
    {
        $user->income()->create(
            Income::factory()->make([
                'name' => 'Salaris', 'amount' => 1000, 'user_id' => $user->id, 'from_id' => $user->piggyBanks->first()->id, 'to_id' => $user->piggyBanks->first()->id,
            ])->toArray()
        );

        $user->income()->create(
            Income::factory()->make([
                'name' => 'Huurtoeslag', 'amount' => 1000, 'user_id' => $user->id, 'from_id' => $user->piggyBanks->first()->id, 'to_id' => $user->piggyBanks->first()->id,
            ])->toArray()
        );
    }

    public function createExpense($user): void
    {
        $user->expense()->create(
            Expense::factory()->make([
                'name' => 'Sportschool', 'amount' => 1000, 'user_id' => $user->id, 'from_id' => $user->piggyBanks->first()->id, 'to_id' => $user->piggyBanks->first()->id,
            ])->toArray()
        );

        $user->expense()->create(
            Expense::factory()->make([
                'name' => 'Telefoon abonnement', 'amount' => 1000, 'user_id' => $user->id, 'from_id' => $user->piggyBanks->first()->id, 'to_id' => $user->piggyBanks->first()->id,
            ])->toArray()
        );
    }

    public function createSaving($user): void
    {
        $user->savings()->create(
            Saving::factory()->make([
                'name' => 'Kleren', 'amount' => 1000, 'user_id' => $user->id, 'from_id' => $user->piggyBanks->first()->id, 'to_id' => $user->piggyBanks->first()->id,
            ])->toArray()
        );

        $user->savings()->create(
            Saving::factory()->make([
                'name' => 'Laptop', 'amount' => 1000, 'user_id' => $user->id, 'from_id' => $user->piggyBanks->first()->id, 'to_id' => $user->piggyBanks->first()->id,
            ])->toArray()
        );
    }

    public function createCollectiveExpense($user): void
    {
        $user->collectiveExpense()->create(
            CollectiveExpense::factory()->make([
                'name' => 'Netflix', 'amount' => 1000, 'user_id' => $user->id, 'from_id' => $user->piggyBanks->first()->id, 'to_id' => $user->piggyBanks->first()->id,
            ])->toArray()
        );

        $user->collectiveExpense()->create(
            CollectiveExpense::factory()->make([
                'name' => 'Boodschappen', 'amount' => 1000, 'user_id' => $user->id, 'from_id' => $user->piggyBanks->first()->id, 'to_id' => $user->piggyBanks->first()->id,
            ])->toArray()
        );
    }

    public function createCollectiveSaving($user): void
    {
        $user->collectiveSaving()->create(
            CollectiveSaving::factory()->make([
                'name' => 'Auto', 'amount' => 1000, 'user_id' => $user->id, 'from_id' => $user->piggyBanks->first()->id, 'to_id' => $user->piggyBanks->first()->id,
            ])->toArray()
        );

        $user->collectiveSaving()->create(
            CollectiveSaving::factory()->make([
                'name' => 'Huiskopen', 'amount' => 1000, 'user_id' => $user->id, 'from_id' => $user->piggyBanks->first()->id, 'to_id' => $user->piggyBanks->first()->id,
            ])->toArray()
        );
    }
}
