<?php

namespace App\Modules\Notification\Infrastructure\Repository;
use App\Modules\Notification\Core\Domain\Repository\NotificationRepository;
use Cache;
use Carbon\Carbon;

use App\Modules\Shared\Core\Domain\Model\Transaction;
use App\Modules\Shared\Core\Domain\Model\User;
use App\Modules\Shared\Core\Domain\Model\Location;
use Illuminate\Database\Eloquent\Collection;
use Auth;


class EloquentNotificationRepository implements NotificationRepository
{
    public function getNotification(): Collection
    {
        if (Auth::user()->role == 'pemilik')
        {
            $notifications = Cache::remember('notifications', 120, function () {
                $current_date = Carbon::now('Asia/Bangkok');
                $tomorow_date = Carbon::tomorrow('Asia/Bangkok');
                return Transaction::where('waktu', '<', $tomorow_date)->where('waktu', '>', $current_date)->where('isReservasi', '=', True)->where('statusTransaksi', '=', 'Belum Dimulai')->orderBy('waktu')->get();
            });
        }
        else
        {
            $notifications = Cache::remember('notifications', 120, function () {
                $current_date = Carbon::now('Asia/Bangkok');
                $tomorow_date = Carbon::tomorrow('Asia/Bangkok');
                return Transaction::where('waktu', '<', $tomorow_date)->where('waktu', '>', $current_date)->where('isReservasi', '=', True)->where('statusTransaksi', '=', 'Belum Dimulai')->where('location_id','=',Auth::user()->location_id)->orderBy('waktu')->get();
            });
        }

        foreach($notifications as $notification)
        {
            $member = User::findOrFail($notification->user_id);
            $notification->member = $member->nama;

            $location = Location::findOrFail($notification->location_id);
            $notification->address = $location->alamat;
        }

        return $notifications;
    }
}
