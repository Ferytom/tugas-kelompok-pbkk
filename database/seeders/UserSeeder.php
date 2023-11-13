<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'nama' => 'Non Member',
            'noTelepon' => '0811234567890',
            'email' => 'non-member@example.com',
            'role' => 'pelanggan',
            'password' => Hash::make('12345678'),
        ]);

        User::factory()->create([
            'nama' => 'Pemilik 1',
            'noTelepon' => '0811234567890',
            'email' => 'pemilik1@example.com',
            'role' => 'pemilik',
            'password' => Hash::make('password'),
        ]);

        User::factory(3)->create();
    }
}
