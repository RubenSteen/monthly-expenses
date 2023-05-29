<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\PiggyBank;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
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
            'category_id' => Category::factory(),
            'amount' => rand(100, 30000),
            'from_id' => function (array $attributes) {
                return PiggyBank::factory()->create(['user_id' => Category::find($attributes['category_id'])->user->id]);
            },
            'to_id' => function (array $attributes) {
                return PiggyBank::factory()->create(['user_id' => Category::find($attributes['category_id'])->user->id]);
            },
        ];
    }
}
