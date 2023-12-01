<?php

namespace Database\Factories\Modules\Shared\Core\Domain\Model;

use Illuminate\Database\Eloquent\Factories\Factory;
use DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Modules\Shared\Core\Domain\Model\Promo>
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

    public function insertRecords(int $x): void
    {
        for ($i = 0; $i < $x; $i++) {
            $data = [
                'nama' => fake()->sentence(2),
                'detail' => fake()->sentence(5),
                'persenDiskon' => fake()->numberBetween(10,75),
                'maxDiskon' => 100000,
                'expired' => '2999-12-31',
            ];
            DB::table('promos')->insert($data);
        }
    }
}
