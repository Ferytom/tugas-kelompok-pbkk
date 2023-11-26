<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Location;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class ReportController extends Controller
{
    private $formData = [];
    public function index()
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
        return view('report.index', compact('transactions'));
    }

    public function daily()
    {
        $transactions = Cache::remember('completedTransactions', 120, function () {
            $current_date = Carbon::now('Asia/Bangkok');
            return Transaction::where('waktu', '<', $current_date)->where('statusTransaksi', '=', 'Selesai')->orderBy('waktu')->get();
        });

        // Group transactions by day
        $groupedTransactions = $transactions->groupBy(function ($transaction) {
            return Carbon::parse($transaction->waktu)->format('Y-m-d');
        });

        // Calculate total income for each day
        $dailyTotals = $groupedTransactions->map(function ($transactions) {
            return $transactions->sum('hargaTotal');
        });

        // Attach additional information to each transaction
        $groupedTransactions = $groupedTransactions->map(function ($transactions) {
            foreach ($transactions as $transaction) {
                $member = User::findOrFail($transaction->user_id);
                $transaction->member = $member->nama;

                $location = Location::findOrFail($transaction->location_id);
                $transaction->address = $location->alamat;
            }
            return $transactions;
        });

        return view('report.daily', compact('groupedTransactions', 'dailyTotals'));
    }

    public function monthly()
    {
        $transactions = Cache::remember('completedTransactions', 120, function () {
            $current_date = Carbon::now('Asia/Bangkok');
            return Transaction::where('waktu', '<', $current_date)->where('statusTransaksi', '=', 'Selesai')->orderBy('waktu')->get();
        });

        // Group transactions by day
        $groupedTransactions = $transactions->groupBy(function ($transaction) {
            return Carbon::parse($transaction->waktu)->format('Y-m');
        });

        // Calculate total income for each day
        $monthlyTotals = $groupedTransactions->map(function ($transactions) {
            return $transactions->sum('hargaTotal');
        });

        // Attach additional information to each transaction
        $groupedTransactions = $groupedTransactions->map(function ($transactions) {
            foreach ($transactions as $transaction) {
                $member = User::findOrFail($transaction->user_id);
                $transaction->member = $member->nama;

                $location = Location::findOrFail($transaction->location_id);
                $transaction->address = $location->alamat;
            }
            return $transactions;
        });

        return view('report.monthly', compact('groupedTransactions', 'monthlyTotals'));
    }

    public function misc()
    {
        $transactions = Cache::remember('completedTransactions', 120, function () {
            $current_date = Carbon::now('Asia/Bangkok');
            return Transaction::where('waktu', '<', $current_date)->where('statusTransaksi', '=', 'Selesai')->orderBy('waktu')->get();
        });

        $highestTotalTransactions = Transaction::where('statusTransaksi', '=', 'Selesai')->orderBy('hargaTotal', 'desc')->take(5)->get();
        foreach($highestTotalTransactions as $transaction)
        {
            $member = User::findOrFail($transaction->user_id);
            $transaction->member = $member->nama;

            $location = Location::findOrFail($transaction->location_id);
            $transaction->alamat = $location->alamat;
        }

        $bestMembers = User::where('role', '=', 'pelanggan')->get();
        foreach($bestMembers as $member)
        {
            $member->totalPengeluaran = Transaction::where('statusTransaksi', '=', 'Selesai')->where('user_id', '=', $member->id)->sum('hargaTotal');
            $member->jumlahTransaksi = Transaction::where('statusTransaksi', '=', 'Selesai')->where('user_id', '=', $member->id)->count();
        }
        $bestMembers = $bestMembers->sortByDesc('totalPengeluaran')->take(5);

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
        
        // Take the top 5 results
        $bestLocations = $bestLocations->take(5);        
        return view('report.misc', compact('highestTotalTransactions', 'bestMembers', 'bestLocations'));
    }
    
}
