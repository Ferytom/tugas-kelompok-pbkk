<?php

namespace Database\Factories;

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
            'waktu' => '2999-01-01',
            'keterangan' => '',
            'hargaTotal' => 100000,
            'statusTransaksi' => 'Selesai',
            'promo_id' => 1,
            'user_id' => 1,
            'location_id' => 1,
            'employee_id' => 1,
        ];
    }
}
