<?php

namespace Database\Seeders;

use App\Modules\Shared\Core\Domain\Model\Menu;
use Illuminate\Database\Seeder;
use DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menus')->insert([
            'nama' => 'Nasi Goreng',
            'harga' => 25000,
            'deskripsi' => 'Deskripsi Nasi Goreng',
            'pathFoto' => 'storage/assets/img/menu/nasi-goreng.jpeg',
        ]);

        DB::table('menus')->insert([
            'nama' => 'Mi Goreng',
            'harga' => 20000,
            'deskripsi' => 'Deskripsi Mi Goreng',
        ]);
    }
}
