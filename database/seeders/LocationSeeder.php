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
            'namaLokasi' => 'Papercup Tunjungan',
            'alamat' => 'Jl. Tunjungan No. 64',
            'googleMap' => 'https://maps.app.goo.gl/BipQ9wA3XdiL6FTf8',
        ]);
        DB::table('locations')->insert([
            'namaLokasi' => 'Papercup Manyar',
            'alamat' => 'Jl. Manyar Kertoarjo No. 75',
            'googleMap' => 'https://maps.app.goo.gl/f7RTgPYRcnsjCH9c8',
        ]);
        DB::table('locations')->insert([
            'namaLokasi' => 'Papercup Kayoon',
            'alamat' => 'Jl. Kayoon No. 48',
            'googleMap' => 'https://maps.app.goo.gl/FG5FKvSyP6rWSUfK8',
        ]);
        DB::table('locations')->insert([
            'namaLokasi' => 'Papercup Citraland',
            'alamat' => 'Jl. Telaga Utama Blok TC - 3',
            'googleMap' => 'https://maps.app.goo.gl/LV8QrmrJ8xvnwVyS8',
        ]);
        
    }
}
