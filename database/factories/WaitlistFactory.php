<?php

namespace Database\Factories\Modules\Shared\Core\Domain\Model;

use Illuminate\Database\Eloquent\Factories\Factory;
use DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Modules\Shared\Core\Domain\Model\Waitlist>
 */
class WaitlistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'jumlahOrang' => fake()->numberBetween(1,5),
            'location_id' => fake()->numberBetween(1,4),
        ];
    }

    public function insertRecords(int $x): void
    {
        for ($i = 0; $i < $x; $i++) {
            $data = [
                'nama' => fake()->name(),
                'jumlahOrang' => fake()->numberBetween(1,5),
                'location_id' => fake()->numberBetween(1,4),
            ];
            DB::table('waitlists')->insert($data);
        }
    }
}
