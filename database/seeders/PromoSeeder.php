<?php

namespace Database\Seeders;

use App\Models\Promo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PromoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Promo::factory()->create([
            'detail' => 'Tidak Menggunakan Promo',
            'persenDiskon' => 0,
            'maxDiskon' => 0,
            'expired' => '2999-12-31',
        ]);

        Promo::factory(3)->create();
    }
}