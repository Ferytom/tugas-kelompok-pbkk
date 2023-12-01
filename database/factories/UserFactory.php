<?php

namespace Database\Factories\Modules\Shared\Core\Domain\Model;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Modules\Shared\Core\Domain\Model\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'noTelepon' => fake()->phoneNumber(),
            'alamat' => fake()->address(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'), // password
            'role' => 'pelanggan',
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function insertRecords(int $x): void
    {
        for ($i = 0; $i < $x; $i++) {
            $data = [
                'nama' => fake()->name(),
                'noTelepon' => fake()->phoneNumber(),
                'alamat' => fake()->address(),
                'email' => fake()->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'), // password
                'role' => 'pelanggan',
                'remember_token' => Str::random(10),
            ];
            DB::table('users')->insert($data);
        }
    }
}
