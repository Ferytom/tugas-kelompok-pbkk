<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

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
            'hargaTotal' => fake()->numberBetween(1,5)*50000,
            'statusTransaksi' => 'Belum Dimulai',
            'noMeja' => fake()->numberBetween(1,15),
            'isReservasi' => true,
            'promo_id' => 1,
            'user_id' => fake()->numberBetween(4,6),
            'location_id' => fake()->numberBetween(1,3),
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
            $randomTimestamp = Carbon::createFromTimestamp($randomTimestamp, 'UTC')->setTimezone('Asia/Bangkok')->addHours(7);

            $statusTransaksi = 'Selesai';
            if (rand(0, 9) === 0) {
                $statusTransaksi = 'Belum Dimulai';
            }

            return [
                'statusTransaksi' => $statusTransaksi,
                'waktu' => $this->formatTimestampInRange($randomTimestamp),
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
            $randomTimestamp = Carbon::createFromTimestamp($randomTimestamp, 'UTC')->setTimezone('Asia/Bangkok')->addHours(7);

            $statusTransaksi = 'Selesai';
            if (rand(0, 9) === 0) {
                $statusTransaksi = 'Belum Dimulai';
            }

            return [
                'statusTransaksi' => $statusTransaksi,
                'waktu' => $this->formatTimestampInRange($randomTimestamp),
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
            $firstDayTimestamp = mktime(0, 0, 0, 11, 1, $currentYear);
            $currentTimestamp = time();
            $lastDayTimestamp = mktime(0, 0, 0, 11, date('t', $firstDayTimestamp), $currentYear);

            $randomTimestamp = rand($currentTimestamp, $lastDayTimestamp);
            $randomTimestamp = Carbon::createFromTimestamp($randomTimestamp, 'UTC')->setTimezone('Asia/Bangkok')->addHours(7);

            return [
                'waktu' => $this->formatTimestampInRange($randomTimestamp),
            ];
        });
    }

    public function offlineState()
    {
        return $this->state(function (array $attributes) {
            $currentYear = date('Y');
            $firstDayTimestamp = mktime(0, 0, 0, 10, 1, $currentYear);
            $currentTimestamp = time();

            $randomTimestamp = rand($firstDayTimestamp, $currentTimestamp);
            $randomTimestamp = Carbon::createFromTimestamp($randomTimestamp, 'UTC')->setTimezone('Asia/Bangkok')->addHours(7);

            $statusTransaksi = 'Selesai';

            $userID = rand(0, 100);
            if ($userID < 80) {
                $userID = 1;
            } else if ($userID < 85) {
                $userID = 4;
            } else if ($userID < 95) {
                $userID = 5;
            } else {
                $userID = 6;
            }

            return [
                'statusTransaksi' => $statusTransaksi,
                'waktu' => $this->formatTimestampInRange($randomTimestamp),
                'isReservasi' => False,
                'user_id' => $userID,
            ];
        });
    }

    private function formatTimestampInRange(Carbon $timestamp): string
    {
        $timestamp = $timestamp->setHour(rand(8, 22))->setMinute(rand(0, 59))->setSecond(rand(0, 59));

        return $timestamp->format('Y-m-d H:i:s');
    }

}
