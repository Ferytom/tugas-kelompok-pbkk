<?php

namespace Database\Factories\Modules\Shared\Core\Domain\Model;

use App\Modules\Shared\Core\Domain\Model\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;
use DB;

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
            'nama' => $this->faker->sentence(2),
            'harga' => $this->faker->numberBetween(5, 50) * 1000,
            'deskripsi' => $this->faker->sentence(5),
            'pathFoto' => 'assets/img/placeholder-menu.jpeg',
        ];
    }

    public function insertRecords(int $x): void
    {
        for ($i = 0; $i < $x; $i++) {
            $data = [
                'nama' => $this->faker->sentence(2),
                'harga' => $this->faker->numberBetween(5, 50) * 1000,
                'deskripsi' => $this->faker->sentence(5),
                'pathFoto' => 'assets/img/placeholder-menu.jpeg',
            ];
            DB::table('menus')->insert($data);
        }
    }
}
