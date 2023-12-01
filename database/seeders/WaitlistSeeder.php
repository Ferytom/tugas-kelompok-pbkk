<?php

namespace Database\Seeders;

use \App\Modules\Shared\Core\Domain\Model\Waitlist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class WaitlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Waitlist::factory()->insertRecords(5);
    }
}
