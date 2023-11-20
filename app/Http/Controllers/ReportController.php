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
        $transactions = Cache::remember('transactions', 120, function () {
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
        $transactions = Cache::remember('transactions', 120, function () {
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
        $transactions = Cache::remember('transactions', 120, function () {
            $current_date = Carbon::now('Asia/Bangkok');
            return Transaction::where('waktu', '<', $current_date)->where('statusTransaksi', '=', 'Selesai')->get();
        });
        return view('report.monthly', compact('transactions'));
    }

    
}
