<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Cache;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    private $formData = [];
    public function index()
    {
        $members = Cache::remember('members', 120, function () {
            return User::where('role', '=', 'pelanggan')->get();
            //return User::all();
        });

        foreach($members as $member)
        {
            $current_date = Carbon::now('Asia/Bangkok');
            $member->offline_transaction = Transaction::where('waktu', '<', $current_date)->where('statusTransaksi', '=', 'Selesai')->where('isReservasi', '=', False)->where('user_id', '=', $member->id)->count();
            $member->completed_reservation = Transaction::where('waktu', '<', $current_date)->where('statusTransaksi', '=', 'Selesai')->where('isReservasi', '=', True)->where('user_id', '=', $member->id)->count();
            $member->expired_reservation = Transaction::where('waktu', '<', $current_date)->where('statusTransaksi', '!=', 'Selesai')->where('isReservasi', '=', True)->where('user_id', '=', $member->id)->count();
            $member->ongoing_reservation = Transaction::where('waktu', '>', $current_date)->where('isReservasi', '=', True)->where('user_id', '=', $member->id)->count();
        }
        
        return view('member.index', compact('members'));
    }
}
