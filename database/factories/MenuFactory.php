<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
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
            'harga' => fake()->numberBetween(5,50)*1000,
            'deskripsi' => fake()->sentence(5),
            'pathFoto' => 'assets/img/placeholder-menu.jpeg',
        ];
    }
}
