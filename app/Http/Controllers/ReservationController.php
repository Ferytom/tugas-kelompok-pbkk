<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Location;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class ReservationController extends Controller
{
    private $formData = [];
    public function index()
    {
        $completed_reservations = Cache::remember('completed_reservations', 120, function () {
            $current_date = Carbon::now();
            return Transaction::where('waktu', '<', $current_date)->where('statusTransaksi', '=', 'Selesai')->where('isReservasi', '=', True)->orderBy('waktu')->get();
        });
        $ongoing_reservations = Cache::remember('ongoing_reservations', 120, function () {
            $current_date = Carbon::now();
            return Transaction::where('waktu', '>=', $current_date)->where('isReservasi', '=', True)->orderBy('waktu')->get();
        });
        $expired_reservations = Cache::remember('expired_reservations', 120, function () {
            $current_date = Carbon::now();
            return Transaction::where('waktu', '<', $current_date)->where('statusTransaksi', '!=', 'Selesai')->where('isReservasi', '=', True)->orderBy('waktu')->get();
        });

        foreach($completed_reservations as $reservation)
        {
            $member = User::findOrFail($reservation->user_id);
            $reservation->member = $member->nama;

            $location = Location::findOrFail($reservation->location_id);
            $reservation->address = $location->alamat;
        }

        foreach($ongoing_reservations as $reservation)
        {
            $member = User::findOrFail($reservation->user_id);
            $reservation->member = $member->nama;

            $location = Location::findOrFail($reservation->location_id);
            $reservation->address = $location->alamat;
        }

        foreach($expired_reservations as $reservation)
        {
            $member = User::findOrFail($reservation->user_id);
            $reservation->member = $member->nama;

            $location = Location::findOrFail($reservation->location_id);
            $reservation->address = $location->alamat;
        }

        return view('reservation.index', compact('completed_reservations', 'ongoing_reservations', 'expired_reservations'));
    }

    public function create()
    {
        return view ('reservation.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('reservation.index')->with('success', 'Reservation has been created!');
    }

    public function edit($id)
    {
        return view('reservation.edit');
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('reservation.index')->with('success', 'Reservation has been updated');    
    }

    public function destroy($id)
    {    
        return redirect()->route('reservation.index')->with('success', 'Reservation deleted successfully');
    }
}
