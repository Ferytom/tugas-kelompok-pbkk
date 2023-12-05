<?php

namespace Database\Factories\Modules\Shared\Core\Domain\Model;

use App\Modules\Shared\Core\Domain\Model\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
use DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Modules\Shared\Core\Domain\Model\Transaction>
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
            'location_id' => fake()->numberBetween(1,4),
        ];
    }

    /**
     * Define the October state for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function octoberRecords(int $x): void
    {
        for ($i = 0; $i < $x; $i++) {
            $data = [
                'waktu' => '2999-01-01',
                'keterangan' => '',
                'hargaTotal' => fake()->numberBetween(1,5)*50000,
                'statusTransaksi' => 'Belum Dimulai',
                'noMeja' => fake()->numberBetween(1,15),
                'isReservasi' => true,
                'promo_id' => fake()->numberBetween(1,4),
                'user_id' => fake()->numberBetween(4,6),
                'location_id' => fake()->numberBetween(1,4),
            ];

            $currentYear = date('Y');
            $firstDayTimestamp = mktime(0, 0, 0, 10, 1, $currentYear);
            $lastDayTimestamp = mktime(0, 0, 0, 10, date('t', $firstDayTimestamp), $currentYear);

            $randomTimestamp = rand($firstDayTimestamp, $lastDayTimestamp);
            $randomTimestamp = Carbon::createFromTimestamp($randomTimestamp, 'UTC')->setTimezone('Asia/Bangkok');

            $statusTransaksi = 'Selesai';
            if (rand(0, 9) === 0) {
                $statusTransaksi = 'Belum Dimulai';
            }

            $data['statusTransaksi'] = $statusTransaksi;
            $data['waktu'] = $this->formatTimestampInRange($randomTimestamp);
            $reservation = Transaction::create($data);

            $jumlahMenu = DB::table('menus')->count();
            $hargaTotal = 0;
            while($hargaTotal == 0)
            {
                for($m=1; $m <= $jumlahMenu; $m++)
                {
                    $menu = DB::table('menus')->where('id','=',$m)->first();
                    $jumlahOrder = rand(0,4);
                    if ($jumlahOrder > 0)
                    {
                        $orderData = [
                            'quantity' => $jumlahOrder,
                            'menu_id' => $m,
                            'transaction_id' => $reservation->id,
                        ];
                        $hargaTotal = $hargaTotal + $menu->harga * $jumlahOrder;
                        DB::table('orders')->insert($orderData);
                    }
                }
            }
            $promo = DB::table('promos')->where('id', '=', $reservation->promo_id)->first();
            $promoPersenDiskon = $promo->persenDiskon;
            $promoMaxDiskon = $promo->maxDiskon;
            $totalDiskon = min($hargaTotal*$promoPersenDiskon/100, $promoMaxDiskon);
            $hargaTotal = max($hargaTotal - $totalDiskon, 0);
            $reservation->hargaTotal = $hargaTotal;
            $reservation->save();
        }
    }

    public function novemberRecords(int $x): void
    {
        for ($i = 0; $i < $x; $i++) {
            $data = [
                'waktu' => '2999-01-01',
                'keterangan' => '',
                'hargaTotal' => fake()->numberBetween(1,5)*50000,
                'statusTransaksi' => 'Belum Dimulai',
                'noMeja' => fake()->numberBetween(1,15),
                'isReservasi' => true,
                'promo_id' => fake()->numberBetween(1,4),
                'user_id' => fake()->numberBetween(4,6),
                'location_id' => fake()->numberBetween(1,4),
            ];

            $currentYear = date('Y');
            $firstDayTimestamp = mktime(0, 0, 0, 11, 1, $currentYear);
            $lastDayTimestamp = mktime(0, 0, 0, 11, date('t', $firstDayTimestamp), $currentYear);

            $randomTimestamp = rand($firstDayTimestamp, $lastDayTimestamp);
            $randomTimestamp = Carbon::createFromTimestamp($randomTimestamp, 'UTC')->setTimezone('Asia/Bangkok');

            $statusTransaksi = 'Selesai';
            if (rand(0, 9) === 0) {
                $statusTransaksi = 'Belum Dimulai';
            }

            $data['statusTransaksi'] = $statusTransaksi;
            $data['waktu'] = $this->formatTimestampInRange($randomTimestamp);
            $reservation = Transaction::create($data);

            $jumlahMenu = DB::table('menus')->count();
            $hargaTotal = 0;
            while($hargaTotal == 0)
            {
                for($m=1; $m <= $jumlahMenu; $m++)
                {
                    $menu = DB::table('menus')->where('id','=',$m)->first();
                    $jumlahOrder = rand(0,4);
                    if ($jumlahOrder > 0)
                    {
                        $orderData = [
                            'quantity' => $jumlahOrder,
                            'menu_id' => $m,
                            'transaction_id' => $reservation->id,
                        ];
                        $hargaTotal = $hargaTotal + $menu->harga * $jumlahOrder;
                        DB::table('orders')->insert($orderData);
                    }
                }
            }
            $promo = DB::table('promos')->where('id', '=', $reservation->promo_id)->first();
            $promoPersenDiskon = $promo->persenDiskon;
            $promoMaxDiskon = $promo->maxDiskon;
            $totalDiskon = min($hargaTotal*$promoPersenDiskon/100, $promoMaxDiskon);
            $hargaTotal = max($hargaTotal - $totalDiskon, 0);
            $reservation->hargaTotal = $hargaTotal;
            $reservation->save();
        }
    }

    public function decemberBeforeNowRecords(int $x): void
    {
        for ($i = 0; $i < $x; $i++) {
            $data = [
                'waktu' => '2999-01-01',
                'keterangan' => '',
                'hargaTotal' => fake()->numberBetween(1,5)*50000,
                'statusTransaksi' => 'Belum Dimulai',
                'noMeja' => fake()->numberBetween(1,15),
                'isReservasi' => true,
                'promo_id' => fake()->numberBetween(1,4),
                'user_id' => fake()->numberBetween(4,6),
                'location_id' => fake()->numberBetween(1,4),
            ];

            $currentYear = date('Y');
            $firstDayTimestamp = mktime(0, 0, 0, 12, 1, $currentYear);
            $currentTimestamp = time();

            $randomTimestamp = rand($firstDayTimestamp, $currentTimestamp);
            $randomTimestamp = Carbon::createFromTimestamp($randomTimestamp, 'UTC')->setTimezone('Asia/Bangkok');

            $statusTransaksi = 'Selesai';
            if (rand(0, 9) === 0) {
                $statusTransaksi = 'Belum Dimulai';
            }

            $data['statusTransaksi'] = $statusTransaksi;
            $data['waktu'] = $this->formatTimestampInRange($randomTimestamp);
            $reservation = Transaction::create($data);

            $jumlahMenu = DB::table('menus')->count();
            $hargaTotal = 0;
            while($hargaTotal == 0)
            {
                for($m=1; $m <= $jumlahMenu; $m++)
                {
                    $menu = DB::table('menus')->where('id','=',$m)->first();
                    $jumlahOrder = rand(0,4);
                    if ($jumlahOrder > 0)
                    {
                        $orderData = [
                            'quantity' => $jumlahOrder,
                            'menu_id' => $m,
                            'transaction_id' => $reservation->id,
                        ];
                        $hargaTotal = $hargaTotal + $menu->harga * $jumlahOrder;
                        DB::table('orders')->insert($orderData);
                    }
                }
            }
            $promo = DB::table('promos')->where('id', '=', $reservation->promo_id)->first();
            $promoPersenDiskon = $promo->persenDiskon;
            $promoMaxDiskon = $promo->maxDiskon;
            $totalDiskon = min($hargaTotal*$promoPersenDiskon/100, $promoMaxDiskon);
            $hargaTotal = max($hargaTotal - $totalDiskon, 0);
            $reservation->hargaTotal = $hargaTotal;
            $reservation->save();
        }
    }

    public function todayReservations(int $x): void
    {
        for ($i = 0; $i < $x; $i++) {
            $data = [
                'waktu' => '2999-01-01',
                'keterangan' => '',
                'hargaTotal' => fake()->numberBetween(1,5)*50000,
                'statusTransaksi' => 'Belum Dimulai',
                'noMeja' => fake()->numberBetween(1,15),
                'isReservasi' => true,
                'promo_id' => fake()->numberBetween(1,4),
                'user_id' => fake()->numberBetween(4,6),
                'location_id' => fake()->numberBetween(1,4),
            ];

            $currentYear = date('Y');
            $firstDayTimestamp = mktime(0, 0, 0, 12, 1, $currentYear);
            $currentTimestamp = Carbon::now('UTC')->setTimezone('Asia/Bangkok');
            $lastHourTimestamp = $currentTimestamp->copy()->setHour(21)->setMinute(0)->setSecond(0);

            $randomTimestamp = rand($currentTimestamp->timestamp, $lastHourTimestamp->timestamp);
            $randomTimestamp = Carbon::createFromTimestamp($randomTimestamp, 'UTC')->setTimezone('Asia/Bangkok');

            $data['waktu'] = $this->formatTimestampInRange($randomTimestamp);
            $reservation = Transaction::create($data);

            $jumlahMenu = DB::table('menus')->count();
            $hargaTotal = 0;
            while($hargaTotal == 0)
            {
                for($m=1; $m <= $jumlahMenu; $m++)
                {
                    $menu = DB::table('menus')->where('id','=',$m)->first();
                    $jumlahOrder = rand(0,4);
                    if ($jumlahOrder > 0)
                    {
                        $orderData = [
                            'quantity' => $jumlahOrder,
                            'menu_id' => $m,
                            'transaction_id' => $reservation->id,
                        ];
                        $hargaTotal = $hargaTotal + $menu->harga * $jumlahOrder;
                        DB::table('orders')->insert($orderData);
                    }
                }
            }
            $promo = DB::table('promos')->where('id', '=', $reservation->promo_id)->first();
            $promoPersenDiskon = $promo->persenDiskon;
            $promoMaxDiskon = $promo->maxDiskon;
            $totalDiskon = min($hargaTotal*$promoPersenDiskon/100, $promoMaxDiskon);
            $hargaTotal = max($hargaTotal - $totalDiskon, 0);
            $reservation->hargaTotal = $hargaTotal;
            $reservation->save();
        }
    }

    public function decemberAfterNowRecords(int $x): void
    {
        for ($i = 0; $i < $x; $i++) {
            $data = [
                'waktu' => '2999-01-01',
                'keterangan' => '',
                'hargaTotal' => fake()->numberBetween(1,5)*50000,
                'statusTransaksi' => 'Belum Dimulai',
                'noMeja' => fake()->numberBetween(1,15),
                'isReservasi' => true,
                'promo_id' => fake()->numberBetween(1,4),
                'user_id' => fake()->numberBetween(4,6),
                'location_id' => fake()->numberBetween(1,4),
            ];

            $currentYear = date('Y');
            $firstDayTimestamp = mktime(0, 0, 0, 12, 1, $currentYear);
            $currentTimestamp = time();
            $lastDayTimestamp = mktime(0, 0, 0, 12, date('t', $firstDayTimestamp), $currentYear);

            $randomTimestamp = rand($currentTimestamp, $lastDayTimestamp);
            $randomTimestamp = Carbon::createFromTimestamp($randomTimestamp, 'UTC')->setTimezone('Asia/Bangkok');

            $data['waktu'] = $this->formatTimestampInRange($randomTimestamp);
            $reservation = Transaction::create($data);

            $jumlahMenu = DB::table('menus')->count();
            $hargaTotal = 0;
            while($hargaTotal == 0)
            {
                for($m=1; $m <= $jumlahMenu; $m++)
                {
                    $menu = DB::table('menus')->where('id','=',$m)->first();
                    $jumlahOrder = rand(0,4);
                    if ($jumlahOrder > 0)
                    {
                        $orderData = [
                            'quantity' => $jumlahOrder,
                            'menu_id' => $m,
                            'transaction_id' => $reservation->id,
                        ];
                        $hargaTotal = $hargaTotal + $menu->harga * $jumlahOrder;
                        DB::table('orders')->insert($orderData);
                    }
                }
            }
            $promo = DB::table('promos')->where('id', '=', $reservation->promo_id)->first();
            $promoPersenDiskon = $promo->persenDiskon;
            $promoMaxDiskon = $promo->maxDiskon;
            $totalDiskon = min($hargaTotal*$promoPersenDiskon/100, $promoMaxDiskon);
            $hargaTotal = max($hargaTotal - $totalDiskon, 0);
            $reservation->hargaTotal = $hargaTotal;
            $reservation->save();
        }
    }

    public function offlineRecords(int $x): void
    {
        for ($i = 0; $i < $x; $i++) {
            $data = [
                'waktu' => '2999-01-01',
                'keterangan' => '',
                'hargaTotal' => fake()->numberBetween(1,5)*50000,
                'statusTransaksi' => 'Selesai',
                'noMeja' => fake()->numberBetween(1,15),
                'isReservasi' => false,
                'promo_id' => fake()->numberBetween(1,4),
                'user_id' => fake()->numberBetween(4,6),
                'location_id' => fake()->numberBetween(1,4),
            ];

            $currentYear = date('Y');
            $firstDayTimestamp = mktime(0, 0, 0, 10, 1, $currentYear);
            $currentTimestamp = time();

            $randomTimestamp = rand($firstDayTimestamp, $currentTimestamp);
            $randomTimestamp = Carbon::createFromTimestamp($randomTimestamp, 'UTC')->setTimezone('Asia/Bangkok');

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

            $data['waktu'] = $this->formatTimestampInRange($randomTimestamp);
            $data['user_id'] = $userID;
            $reservation = Transaction::create($data);

            $jumlahMenu = DB::table('menus')->count();
            $hargaTotal = 0;
            while($hargaTotal == 0)
            {
                for($m=1; $m <= $jumlahMenu; $m++)
                {
                    $menu = DB::table('menus')->where('id','=',$m)->first();
                    $jumlahOrder = rand(0,4);
                    if ($jumlahOrder > 0)
                    {
                        $orderData = [
                            'quantity' => $jumlahOrder,
                            'menu_id' => $m,
                            'transaction_id' => $reservation->id,
                        ];
                        $hargaTotal = $hargaTotal + $menu->harga * $jumlahOrder;
                        DB::table('orders')->insert($orderData);
                    }
                }
            }
            $promo = DB::table('promos')->where('id', '=', $reservation->promo_id)->first();
            $promoPersenDiskon = $promo->persenDiskon;
            $promoMaxDiskon = $promo->maxDiskon;
            $totalDiskon = min($hargaTotal*$promoPersenDiskon/100, $promoMaxDiskon);
            $hargaTotal = max($hargaTotal - $totalDiskon, 0);
            $reservation->hargaTotal = $hargaTotal;
            $reservation->save();
        }
    }

    public function ongoingTransactions(int $x): void
    {
        for ($i = 0; $i < $x; $i++) {
            $data = [
                'waktu' => '2999-01-01',
                'keterangan' => '',
                'hargaTotal' => fake()->numberBetween(1, 5) * 50000,
                'statusTransaksi' => 'Sedang Berjalan',
                'noMeja' => fake()->numberBetween(1, 15),
                'isReservasi' => false,
                'promo_id' => 1,
                'user_id' => fake()->numberBetween(4, 6),
                'location_id' => fake()->numberBetween(1, 4),
            ];

            $currentYear = date('Y');
            $firstDayTimestamp = Carbon::now()->startOfDay()->setHour(8)->timestamp;
            $currentTimestamp = time();

            $randomTimestamp = rand($firstDayTimestamp, $currentTimestamp);
            $randomTimestamp = Carbon::createFromTimestamp($randomTimestamp, 'UTC')->setTimezone('Asia/Bangkok');

            $userID = rand(0, 100);
            if ($userID < 98) {
                $userID = 1;
            } else if ($userID < 99) {
                $userID = 4;
            } else if ($userID < 100) {
                $userID = 5;
            } else {
                $userID = 6;
            }

            $data['waktu'] = $this->formatTimestampInRange($randomTimestamp);
            $data['user_id'] = $userID;
            $reservation = Transaction::create($data);

            $jumlahMenu = DB::table('menus')->count();
            $hargaTotal = 0;
            while($hargaTotal == 0)
            {
                for($m=1; $m <= $jumlahMenu; $m++)
                {
                    $menu = DB::table('menus')->where('id','=',$m)->first();
                    $jumlahOrder = rand(0,4);
                    if ($jumlahOrder > 0)
                    {
                        $orderData = [
                            'quantity' => $jumlahOrder,
                            'menu_id' => $m,
                            'transaction_id' => $reservation->id,
                        ];
                        $hargaTotal = $hargaTotal + $menu->harga * $jumlahOrder;
                        DB::table('orders')->insert($orderData);
                    }
                }
            }
            $reservation->hargaTotal = $hargaTotal;
            $reservation->save();
        }
    }


    private function formatTimestampInRange(Carbon $timestamp): string
    {
        if ($timestamp->hour < 8)
        {
            $timestamp->hour = 8;
        }
        if ($timestamp->hour > 21)
        {
            $timestamp->hour = 21;
        }

        return $timestamp->format('Y-m-d H:i:s');
    }

}
