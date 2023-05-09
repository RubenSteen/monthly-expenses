<?php

namespace Database\Factories;

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
            'user_id' => \App\Models\User::factory()->create(),
            'amount' => rand(100, 100000),
            'from' => function (array $attributes) {
                return \App\Models\PiggyBank::factory()->create(['user_id' => $attributes['user_id']]);
            },
            'to' => function (array $attributes) {
                return \App\Models\PiggyBank::factory()->create(['user_id' => $attributes['user_id']]);
            },
        ];
    }
}
