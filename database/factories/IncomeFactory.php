<?php

namespace Database\Factories;

use App\Models\PiggyBank;
use App\Models\User;
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
        return [
            'name' => $this->faker->catchPhrase(),
            'user_id' => User::factory(),
            'amount' => 1000,
            'from_id' => function (array $attributes) {
                return PiggyBank::factory()->create(['user_id' => $attributes['user_id']]);
            },
            'to_id' => function (array $attributes) {
                return PiggyBank::factory()->create(['user_id' => $attributes['user_id']]);
            },
        ];
    }
}
