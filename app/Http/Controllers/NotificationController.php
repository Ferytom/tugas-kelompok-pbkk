<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Location;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Cache;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Cache::remember('notifications', 120, function () {
            $current_date = Carbon::now('Asia/Bangkok');
            $tomorow_date = Carbon::tomorrow('Asia/Bangkok');
            return Transaction::where('waktu', '<', $tomorow_date)->where('waktu', '>', $current_date)->where('isReservasi', '=', True)->orderBy('waktu')->get();
        });

        foreach($notifications as $notification)
        {
            $member = User::findOrFail($notification->user_id);
            $notification->member = $member->nama;

            $location = Location::findOrFail($notification->location_id);
            $notification->address = $location->alamat;
        }
        return view('notification.index', compact('notifications'));
    }
}
