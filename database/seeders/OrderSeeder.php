<?php

namespace Database\Seeders;

use \App\Modules\Shared\Core\Domain\Model\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('orders')->insert([
            'quantity' => 4,
            'menu_id' => 1,
            'transaction_id' => 1,
        ]);
    }
}
