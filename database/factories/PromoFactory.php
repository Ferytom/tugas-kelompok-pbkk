<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Promo>
 */
class PromoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->sentence(2),
            'detail' => fake()->sentence(5),
            'persenDiskon' => fake()->numberBetween(10,75),
            'maxDiskon' => 100000,
            'expired' => '2999-12-31',
        ];
    }
}
