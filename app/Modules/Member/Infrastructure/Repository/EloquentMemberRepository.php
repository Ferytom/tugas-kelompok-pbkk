<?php

namespace App\Modules\Member\Infrastructure\Repository;
use App\Modules\Member\Core\Domain\Repository\MemberRepository;
use Cache;
use Carbon\Carbon;

use App\Modules\Shared\Core\Domain\Model\User;
use App\Modules\Shared\Core\Domain\Model\Transaction;
use App\Modules\Shared\Core\Domain\Model\Location;
use Illuminate\Database\Eloquent\Collection;


class EloquentMemberRepository implements MemberRepository
{
    public function getAllMembers(): Collection
    {
        $members = Cache::remember('members', 120, function () {
            return User::where('role', '=', 'pelanggan')->get();
        });

        foreach($members as $member)
        {
            $current_date = Carbon::now('Asia/Bangkok');
            $member->offline_transaction = Transaction::where('waktu', '<', $current_date)->where('statusTransaksi', '=', 'Selesai')->where('isReservasi', '=', False)->where('user_id', '=', $member->id)->count();
            $member->completed_reservation = Transaction::where('waktu', '<', $current_date)->where('statusTransaksi', '=', 'Selesai')->where('isReservasi', '=', True)->where('user_id', '=', $member->id)->count();
            $member->expired_reservation = Transaction::where('waktu', '<', $current_date)->where('statusTransaksi', '!=', 'Selesai')->where('isReservasi', '=', True)->where('user_id', '=', $member->id)->count();
            $member->ongoing_reservation = Transaction::where('waktu', '>', $current_date)->where('isReservasi', '=', True)->where('user_id', '=', $member->id)->count();
        }

        return $members;
    }
}
