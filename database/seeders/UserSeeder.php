<?php

namespace Database\Seeders;

use \App\Modules\Shared\Core\Domain\Model\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'nama' => 'Non Member',
            'noTelepon' => '0811234567890',
            'email' => 'non-member@example.com',
            'role' => 'pelanggan',
            'password' => Hash::make('12345678'),
        ]);

        DB::table('users')->insert([
            'nama' => 'Pemilik 1',
            'noTelepon' => '0811234567890',
            'email' => 'pemilik1@example.com',
            'role' => 'pemilik',
            'password' => Hash::make('password'),
            'location_id' => 1,
        ]);
        
        DB::table('users')->insert([
            'nama' => 'Karyawan 1',
            'noTelepon' => '0819876543210',
            'email' => 'karyawan1@example.com',
            'role' => 'karyawan',
            'password' => Hash::make('password'),
            'location_id' => 1,
        ]);

        User::factory()->insertRecords(3);
    }
}
