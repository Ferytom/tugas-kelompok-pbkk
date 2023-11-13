<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Transaction::factory()->create([
            'waktu' => '2023-01-01',
            'keterangan' => '',
            'hargaTotal' => 100000,
            'statusTransaksi' => 'Selesai',
            'promo_id' => 1,
            'user_id' => 1,
        ]);
    }
}
