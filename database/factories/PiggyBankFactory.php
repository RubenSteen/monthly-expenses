<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PiggyBank>
 */
class PiggyBankFactory extends Factory
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
            'user_id' => \App\Models\User::factory(),
            'description' => $this->faker->boolean(50) ? $this->faker->realTextBetween(20, 100) : null,
        ];
    }
}
