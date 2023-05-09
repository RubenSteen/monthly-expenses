<?php

namespace Database\Factories;

use App\Models\PiggyBank;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Income>
 */
class IncomeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = \App\Models\User::factory()->create();
        $firstPiggyBank = PiggyBank::factory()->create(['user_id' => $user->id]);
        $secondPiggyBank = PiggyBank::factory()->create(['user_id' => $user->id]);

        return [
            'name' => $this->faker->catchPhrase(),
            'user_id' => $user->id,
            'amount' => rand(100, 100000),
            'from' => $firstPiggyBank->id,
            'to' => $secondPiggyBank->id,
        ];
    }
}
