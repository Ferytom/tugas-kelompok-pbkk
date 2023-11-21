<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\Promo;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Location;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ReservationController extends Controller
{
    private $formData = [];
    public function index()
    {
        if(Auth::user()->role != 'pelanggan')
        {
            $completed_reservations = Cache::remember('completed_reservations', 120, function () {
                $current_date = Carbon::now('Asia/Bangkok');
                return Transaction::where('waktu', '<', $current_date)->where('statusTransaksi', '=', 'Selesai')->where('isReservasi', '=', True)->orderBy('waktu')->get();
            });
            $ongoing_reservations = Cache::remember('ongoing_reservations', 120, function () {
                $current_date = Carbon::now('Asia/Bangkok');
                return Transaction::where('waktu', '>=', $current_date)->where('isReservasi', '=', True)->orderBy('waktu')->get();
            });
            $expired_reservations = Cache::remember('expired_reservations', 120, function () {
                $current_date = Carbon::now('Asia/Bangkok');
                return Transaction::where('waktu', '<', $current_date)->where('statusTransaksi', '!=', 'Selesai')->where('isReservasi', '=', True)->orderBy('waktu')->get();
            });
        }
        else
        {
            $completed_reservations = Cache::remember('completed_reservations' . Auth::user()->id, 120, function () {
                $current_date = Carbon::now('Asia/Bangkok');
                return Transaction::where('waktu', '<', $current_date)->where('statusTransaksi', '=', 'Selesai')->where('isReservasi', '=', True)->where('user_id', '=', Auth::user()->id)->orderBy('waktu')->get();
            });
            $ongoing_reservations = Cache::remember('ongoing_reservations'  . Auth::user()->id, 120, function () {
                $current_date = Carbon::now('Asia/Bangkok');
                return Transaction::where('waktu', '>=', $current_date)->where('isReservasi', '=', True)->where('user_id', '=', Auth::user()->id)->orderBy('waktu')->get();
            });
            $expired_reservations = Cache::remember('expired_reservations'  . Auth::user()->id, 120, function () {
                $current_date = Carbon::now('Asia/Bangkok');
                return Transaction::where('waktu', '<', $current_date)->where('statusTransaksi', '!=', 'Selesai')->where('isReservasi', '=', True)->where('user_id', '=', Auth::user()->id)->orderBy('waktu')->get();
            });
        }

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

            $currentDate = Carbon::now('Asia/Bangkok');
            $reservationDate = Carbon::parse($reservation->waktu);

            $hoursDifference = $currentDate->diffInHours($reservationDate);

            if ($hoursDifference > 24+7) {
                $reservation->editable = true;
            } else {
                $reservation->editable = false;
            }

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
        $locations = Cache::remember('locations', 120, function () {
            return Location::all();
        });

        $menus = Cache::remember('menus', 120, function () {
            return Menu::all();
        });

        $promos = Cache::remember('promos', 120, function () {
            return Promo::all();
        });
        return view ('reservation.create', compact('locations', 'menus', 'promos'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'required|exists:locations,id',
            'datetime' => function ($attribute, $value, $failed) {
                if (Carbon::parse($value) < Carbon::now()->addDay()->startOfDay()) {
                    $failed('The date must be in the future.');
                }
                if (Carbon::parse($value)->hour < 9 || Carbon::parse($value)->hour > 21) {
                    $failed('The time must be between 9 AM and 9 PM.');
                }
            },
            'total_price' => 'required|numeric',
            'notes' => 'nullable|string',
            'menu_ids' => 'required|array',
            'menu_ids.*' => 'exists:menus,id',
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1',
            'promo' => 'nullable|exists:promos,id',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $reservation = Transaction::create([
            'waktu' => $request->input('datetime'),
            'keterangan' => $request->input('notes'),
            'hargaTotal' => $request->input('total_price'),
            'statusTransaksi' => "Belum Dimulai",
            'isReservasi' => True,
            'promo_id' => $request->input('promo'),
            'user_id' => Auth::user()->id,
            'location_id' => $request->input('address'),
        ]);

        for ($i = 0; $i < count($request->input('menu_ids')); $i++) {
            Order::create([
                'quantity' => json_decode($request->input('quantities')[$i])[0],
                'transaction_id' => $reservation->id,
                'menu_id' => json_decode($request->input('menu_ids')[$i])[0],
            ]);
        }

        return redirect()->route('reservation.index')->with('success', 'Reservation created successfully');
    }

    public function edit($id)
    {
        $reservation = Cache::remember('reservations:' . $id, 120, function () use ($id) {
            return Transaction::findOrFail($id);
        });
        $orders = Cache::remember('orders:' . $id, 120, function () use ($id) {
            return Order::where('transaction_id', '=', $id)->get();
        });
        $locations = Cache::remember('locations', 120, function () {
            return Location::all();
        });
        $menus = Cache::remember('menus', 120, function () {
            return Menu::all();
        });
        $promos = Cache::remember('promos', 120, function () {
            return Promo::all();
        });

        foreach($orders as $order)
        {
            $menu = Menu::findOrFail($order->menu_id);
            $order->nama = $menu->nama;
            $order->harga = $menu->harga;
        }

        if((Auth::user()->role == 'pelanggan') && (Auth::user()->id != $reservation->user_id))
        {
            return redirect()->route('reservation.index')->with('success', 'You do not have permission to edit this reservation');
        }

        $currentDate = Carbon::now('Asia/Bangkok');
        $reservationDate = Carbon::parse($reservation->waktu);

        $hoursDifference = $currentDate->diffInHours($reservationDate);

        if ($hoursDifference < 24+7) {
            return redirect()->route('reservation.index')->with('success', 'You can only edit this reservation until H-24 hours');
        }

        return view('reservation.edit', compact('reservation', 'orders', 'locations', 'menus', 'promos'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'required|exists:locations,id',
            'noMeja' => 'numeric',
            'datetime' => function ($attribute, $value, $failed) {
                if (Carbon::parse($value) < Carbon::now()->addDay()->startOfDay()) {
                    $failed('The date must be in the future.');
                }
                if (Carbon::parse($value)->hour < 9 || Carbon::parse($value)->hour > 21) {
                    $failed('The time must be between 9 AM and 9 PM.');
                }
            },
            'total_price' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $reservation = Transaction::find($id);
        if($request->input('datetime'))
        {
            $reservation->waktu = $request->input('datetime');
        }
        if($request->input('noMeja'))
        {
            $reservation->noMeja = $request->input('noMeja');
        }
        if($request->input('notes'))
        {
            $reservation->keterangan = $request->input('notes');
        }
        if($request->input('total_price'))
        {
            $reservation->hargaTotal = $request->input('total_price');
        }
        if($request->input('promo'))
        {
            $reservation->promo_id = $request->input('promo');
        }
        if($request->input('address'))
        {
            $reservation->location_id = $request->input('address');
        }
        if ($request->input('reservation_status'))
        {
            $reservation->statusTransaksi = $request->input('reservation_status');
        }
        $reservation->save();

        $orders = Order::where('transaction_id', '=', $id)->get();
        foreach($orders as $order)
        {
            $order->delete();
        }

        for ($i = 0; $i < count($request->input('menu_ids')); $i++) {
            Order::create([
                'quantity' => json_decode($request->input('quantities')[$i])[0],
                'transaction_id' => $reservation->id,
                'menu_id' => json_decode($request->input('menu_ids')[$i])[0],
            ]);
        }

        Cache::forget('completed_reservations');
        Cache::forget('expired_reservations');
        Cache::forget('ongoing_reservations');
        return redirect()->route('reservation.index')->with('success', 'Reservation has been updated');    
    }

    public function detail($id)
    {
        $reservation = Cache::remember('reservations:' . $id, 120, function () use ($id) {
            return Transaction::findOrFail($id);
        });
        $orders = Cache::remember('orders:' . $id, 120, function () use ($id) {
            return Order::where('transaction_id', '=', $id)->get();
        });

        $location = Location::findOrFail($reservation->location_id);
        $reservation->alamat = $location->alamat;

        $member = User::findOrFail($reservation->user_id);
        $reservation->pemesan = $member->nama;

        $promo = Promo::findOrFail($reservation->promo_id);

        foreach($orders as $order)
        {
            $menu = Menu::findOrFail($order->menu_id);
            $order->nama = $menu->nama;
            $order->harga = $menu->harga;
        }

        if((Auth::user()->role == 'pelanggan') && (Auth::user()->id != $reservation->user_id))
        {
            return redirect()->route('reservation.index')->with('success', 'You do not have permission to view this reservation');
        }

        return view('reservation.detail', compact('reservation', 'orders', 'promo'));
    }

    public function destroy($id)
    {
        $reservation = Transaction::findOrFail($id);
        if((Auth::user()->role == 'pemilik') || ((Auth::user()->role == 'pelanggan') && (Auth::user()->id != $reservation->user_id)))
        {
            $currentDate = Carbon::now('Asia/Bangkok');
            $reservationDate = Carbon::parse($reservation->waktu);

            $hoursDifference = $currentDate->diffInHours($reservationDate);

            if ($hoursDifference < 24+7) {
                return redirect()->route('reservation.index')->with('success', 'You can only delete this reservation until H-24 hours');
            }
            
            $reservation->delete();
            return redirect()->route('reservation.index')->with('success', 'Reservation deleted successfully');
        }
        return redirect()->route('reservation.index')->with('success', 'You do not have permission to delete this reservation');
    }
}