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
        Transaction::factory(25)->octoberState()->create();
        Transaction::factory(20)->novemberBeforeNowState()->create();
        Transaction::factory(15)->novemberAfterNowState()->create();
        Transaction::factory(100)->offlineState()->create();
        Transaction::factory(1)->create();
    }
}
