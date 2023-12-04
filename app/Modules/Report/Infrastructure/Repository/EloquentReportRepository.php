<?php

namespace App\Modules\Report\Infrastructure\Repository;
use App\Modules\Report\Core\Domain\Repository\ReportRepository;
use Cache;
use Carbon\Carbon;

use App\Modules\Shared\Core\Domain\Model\Transaction;
use App\Modules\Shared\Core\Domain\Model\User;
use App\Modules\Shared\Core\Domain\Model\Menu;
use App\Modules\Shared\Core\Domain\Model\Order;
use App\Modules\Shared\Core\Domain\Model\Location;
use Illuminate\Database\Eloquent\Collection;


class EloquentReportRepository implements ReportRepository
{
    public function getCompletedTransactions(): Collection
    {
        $transactions = Cache::remember('completedTransactions', 120, function () {
            $current_date = Carbon::now('Asia/Bangkok');
            return Transaction::where('waktu', '<', $current_date)->where('statusTransaksi', '=', 'Selesai')->orderBy('waktu')->get();
        });

        foreach($transactions as $transaction)
        {
            $member = User::findOrFail($transaction->user_id);
            $transaction->member = $member->nama;

            $location = Location::findOrFail($transaction->location_id);
            $transaction->address = $location->alamat;
        }

        return $transactions;
    }

    public function getDailyReport(): Collection
    {
        $transactions = Cache::remember('completedTransactions', 120, function () {
            $current_date = Carbon::now('Asia/Bangkok');
            return Transaction::where('waktu', '<', $current_date)->where('statusTransaksi', '=', 'Selesai')->orderBy('waktu')->get();
        });

        $groupedTransactions = $transactions->groupBy(function ($transaction) {
            return Carbon::parse($transaction->waktu)->format('Y-m-d');
        });


        return $groupedTransactions;
    }
    
    public function getMonthlyReport(): Collection
    {
        $transactions = Cache::remember('completedTransactions', 120, function () {
            $current_date = Carbon::now('Asia/Bangkok');
            return Transaction::where('waktu', '<', $current_date)->where('statusTransaksi', '=', 'Selesai')->orderBy('waktu')->get();
        });

        $groupedTransactions = $transactions->groupBy(function ($transaction) {
            return Carbon::parse($transaction->waktu)->format('Y-m');
        });

        return $groupedTransactions;
    }

    public function getHighestTransaction(): Collection
    {
        $highestTotalTransactions = Transaction::where('statusTransaksi', '=', 'Selesai')->orderBy('hargaTotal', 'desc')->take(5)->get();
        foreach($highestTotalTransactions as $transaction)
        {
            $member = User::findOrFail($transaction->user_id);
            $transaction->member = $member->nama;

            $location = Location::findOrFail($transaction->location_id);
            $transaction->alamat = $location->alamat;
        }
        return $highestTotalTransactions;
    }

    public function getBestMember(): Collection
    {
        $bestMembers = User::where('role', '=', 'pelanggan')->where('id', '>', 1)->get();
        foreach($bestMembers as $member)
        {
            $member->totalPengeluaran = Transaction::where('statusTransaksi', '=', 'Selesai')->where('user_id', '=', $member->id)->sum('hargaTotal');
            $member->jumlahTransaksi = Transaction::where('statusTransaksi', '=', 'Selesai')->where('user_id', '=', $member->id)->count();
        }
        $bestMembers = $bestMembers->sortByDesc('totalPengeluaran')->take(5);
        
        return $bestMembers;
    }

    public function getBestLocation(): Collection
    {
        $bestLocations = Location::all();

        foreach($bestLocations as $location)
        {
            $location->totalPendapatan = Transaction::where('statusTransaksi', '=', 'Selesai')->where('location_id', '=', $location->id)->sum('hargaTotal');
            $location->jumlahTransaksi = Transaction::where('statusTransaksi', '=', 'Selesai')->where('location_id', '=', $location->id)->count();
        }

        $bestLocations = $bestLocations->sort(function ($locationA, $locationB) {
            $compareTotalPendapatan = $locationB->totalPendapatan - $locationA->totalPendapatan;
        
            return $compareTotalPendapatan !== 0
                ? $compareTotalPendapatan
                : $locationB->jumlahTransaksi - $locationA->jumlahTransaksi;
        });
        
        $bestLocations = $bestLocations->take(5);

        return $bestLocations;
    }

    public function getBestFood(): Collection
    {
        $bestMenus = Menu::all();
        foreach($bestMenus as $menu)
        {
            $menu->jumlahOrder = Order::where('menu_id', '=', $menu->id)->sum('quantity');
        }

        $bestMenus = $bestMenus->sort(function ($menuA, $menuB) {
            $compareTotalOrder = $menuB->jumlahOrder - $menuA->jumlahOrder;
        
            return $compareTotalOrder !== 0
                ? $compareTotalOrder
                : $menuB->jumlahOrder - $menuA->jumlahOrder;
        });

        $bestMenus = $bestMenus->take(5);

        return $bestMenus;
    }

    public function getTotalIncome(Collection $groupedTransactions): Collection
    {
        $totalIncome = $groupedTransactions->map(function ($transactions) {
            return $transactions->sum('hargaTotal');
        });

        return new Collection($totalIncome->toArray());
    }
}
