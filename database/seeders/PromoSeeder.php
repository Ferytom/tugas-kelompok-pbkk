<?php

namespace Database\Seeders;

use \App\Modules\Shared\Core\Domain\Model\Promo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class PromoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('promos')->insert([
            'nama' => 'No Promo',
            'detail' => 'Tidak Menggunakan Promo',
            'persenDiskon' => 0,
            'maxDiskon' => 0,
            'expired' => '2999-12-31',
        ]);

        Promo::factory()->insertRecords(3);
        
        DB::table('promos')->insert([
            'nama' => 'Contoh Expired',
            'detail' => 'Contoh Expired',
            'persenDiskon' => 20,
            'maxDiskon' => 300000,
            'expired' => '1999-12-31',
        ]);
    }
}
