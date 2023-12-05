<?php

namespace Database\Seeders;

use \App\Modules\Shared\Core\Domain\Model\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Transaction::factory()->octoberRecords(25);
        Transaction::factory()->novemberRecords(50);
        Transaction::factory()->decemberBeforeNowRecords(10);
        Transaction::factory()->todayReservations(5);
        Transaction::factory()->decemberAfterNowRecords(100);
        Transaction::factory()->offlineRecords(300);
        Transaction::factory()->ongoingTransactions(35);
        
        DB::table('transactions')->insert([
            'waktu' => '2999-01-01',
            'keterangan' => '',
            'hargaTotal' => fake()->numberBetween(1,5)*50000,
            'statusTransaksi' => 'Belum Dimulai',
            'noMeja' => fake()->numberBetween(1,15),
            'isReservasi' => true,
            'promo_id' => 1,
            'user_id' => fake()->numberBetween(4,6),
            'location_id' => fake()->numberBetween(1,4),
        ]);
    }
}
