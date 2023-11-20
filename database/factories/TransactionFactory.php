<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'waktu' => '2999-01-01',
            'keterangan' => '',
            'hargaTotal' => 100000,
            'statusTransaksi' => 'Belum Dimulai',
            'isReservasi' => true,
            'promo_id' => 1,
            'user_id' => 4,
            'location_id' => 1,
            'employee_id' => 1,
        ];
    }

    /**
     * Define the October state for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function octoberState()
    {
        return $this->state(function (array $attributes) {
            $currentYear = date('Y');
            $firstDayTimestamp = mktime(0, 0, 0, 10, 1, $currentYear);
            $lastDayTimestamp = mktime(0, 0, 0, 10, date('t', $firstDayTimestamp), $currentYear);

            $randomTimestamp = rand($firstDayTimestamp, $lastDayTimestamp);
            $randomTime = date('Y-m-d H:i:s', $randomTimestamp);

            $statusTransaksi = 'Selesai';
            if (rand(0, 9) === 0) {
                $statusTransaksi = 'Belum Dimulai';
            }

            return [
                'statusTransaksi' => $statusTransaksi,
                'waktu' => $randomTime,
            ];
        });
    }

    /**
     * Define the November before now state for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function novemberBeforeNowState()
    {
        return $this->state(function (array $attributes) {
            $currentYear = date('Y');
            $firstDayTimestamp = mktime(0, 0, 0, 11, 1, $currentYear);
            $currentTimestamp = time();

            $randomTimestamp = rand($firstDayTimestamp, $currentTimestamp);
            $randomTime = date('Y-m-d H:i:s', $randomTimestamp);

            $statusTransaksi = 'Selesai';
            if (rand(0, 9) === 0) {
                $statusTransaksi = 'Belum Dimulai';
            }

            return [
                'statusTransaksi' => $statusTransaksi,
                'waktu' => $randomTime,
            ];
        });
    }

    /**
     * Define the November after now state for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function novemberAfterNowState()
    {
        return $this->state(function (array $attributes) {
            $currentYear = date('Y');
            $firstDayTimestamp = mktime(0, 0, 0, 10, 1, $currentYear);
            $currentTimestamp = time();
            $lastDayTimestamp = mktime(0, 0, 0, 10, date('t', $firstDayTimestamp), $currentYear);

            $randomTimestamp = rand($currentTimestamp, $lastDayTimestamp);
            $randomTime = date('Y-m-d H:i:s', $randomTimestamp);

            return [
                'waktu' => $randomTime,
            ];
        });
    }
}
