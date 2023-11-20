<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Cache;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Cache::remember('notifications', 120, function () {
            $current_date = Carbon::now();
            $yesterday_date = Carbon::yesterday();
            return Transaction::where('waktu', '<', $current_date)->where('waktu', '>', $yesterday_date)->where('isReservasi', '=', True)->orderBy('waktu')->get();
        });
        return view('notification.index', compact('notifications'));
    }
}
