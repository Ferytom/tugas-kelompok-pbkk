<?php

namespace Database\Factories\Modules\Shared\Core\Domain\Model;

use Illuminate\Database\Eloquent\Factories\Factory;
use DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Modules\Shared\Core\Domain\Model\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quantity' => fake()->numberBetween(1,10),
            'menu_id' => 1,
            'transaction_id' => 1,
        ];
    }

    public function insertRecords(int $x): void
    {
        for ($i = 0; $i < $x; $i++) {
            $data = [
                'quantity' => fake()->numberBetween(1,10),
                'menu_id' => 1,
                'transaction_id' => 1,
            ];
            DB::table('orders')->insert($data);
        }
    }
}
