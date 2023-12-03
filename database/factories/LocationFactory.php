<?php

namespace Database\Factories\Modules\Shared\Core\Domain\Model;

use Illuminate\Database\Eloquent\Factories\Factory;
use DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Modules\Shared\Core\Domain\Model\Menu>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'alamat' => fake()->sentence(2),
        ];
    }
    
    public function insertRecords(int $x): void
    {
        for ($i = 0; $i < $x; $i++) {
            $data = [
                'namaLokasi' => fake()->sentence(2),
                'alamat' => fake()->sentence(2),
            ];
            DB::table('locations')->insert($data);
        }
    }
}
