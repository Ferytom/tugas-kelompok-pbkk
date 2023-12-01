<?php

namespace Database\Seeders;

use \App\Modules\Shared\Core\Domain\Model\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('locations')->insert([
            'alamat' => 'lokasi 1',
        ]);
        DB::table('locations')->insert([
            'alamat' => 'lokasi 2',
        ]);
        DB::table('locations')->insert([
            'alamat' => 'lokasi 3',
        ]);
        
    }
}
