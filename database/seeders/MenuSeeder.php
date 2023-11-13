<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::factory()->create([
            'nama' => 'Nasi Goreng',
            'harga' => 25000,
            'deskripsi' => 'Deskripsi Nasi Goreng',
            'pathFoto' => 'assets/img/nasi-goreng.jpeg',
        ]);
    }
}
