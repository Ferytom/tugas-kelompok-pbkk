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

class TransactionController extends Controller
{
    private $formData = [];
    public function index()
    {
        $transactions = Cache::remember('transactions', 120, function () {
            return Transaction::where('statusTransaksi', '=', 'Sedang Berjalan')->orderBy('waktu')->get();
        });

        foreach($transactions as $transaction)
        {
            $location = Location::findOrFail($transaction->location_id);
            $transaction->address = $location->alamat;
        }

        return view('transaction.index', compact('transactions'));
    }

    public function create()
    {
        $members = Cache::remember('members', 120, function() {
            return User::where('role', '=', 'pelanggan')->get();
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
        return view ('reservation.create', compact('members', 'locations', 'menus', 'promos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user' => 'required|exists:users,id',
            'address' => 'required|exists:locations,id',
            'total_price' => 'required|numeric',
            'notes' => 'nullable|string',
            'menu_ids' => 'required|array',
            'menu_ids.*' => 'exists:menus,id',
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1',
            'promo' => 'nullable|exists:promos,id',
        ]);

        $transaction = Transaction::create([
            'waktu' => Carbon::now(),
            'keterangan' => $request->input('notes'),
            'hargaTotal' => $request->input('total_price'),
            'statusTransaksi' => "Sedang Berjalan",
            'isReservasi' => False,
            'promo_id' => $request->input('promo'),
            'user_id' => $request->input('user'),
            'location_id' => $request->input('address'),
        ]);

        for ($i = 0; $i < count($request->input('menu_ids')); $i++) {
            Order::create([
                'quantity' => json_decode($request->input('quantities')[$i])[0],
                'transaction_id' => $transaction->id,
                'menu_id' => json_decode($request->input('menu_ids')[$i])[0],
            ]);
        }

        Cache::forget('transactions');

        return redirect()->route('transaction.index')->with('success', 'Transaction created successfully');
    }

    public function edit($id)
    {
        $transaction = Cache::remember('transactions:' . $id, 120, function () use ($id) {
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

        if((Auth::user()->role != 'pemilik') && (Auth::user()->location_id != $transaction->location_id))
        {
            return redirect()->route('transaction.index')->with('success', 'You do not have permission to edit this reservation');
        }

        return view('transaction.edit', compact('transaction', 'orders', 'locations', 'menus', 'promos'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'user' => 'exists:users,id',
            'address' => 'exists:locations,id',
            'total_price' => 'numeric',
            'notes' => 'nullable|string',
            'menu_ids' => 'array',
            'menu_ids.*' => 'exists:menus,id',
            'quantities' => 'array',
            'quantities.*' => 'integer|min:1',
            'promo' => 'nullable|exists:promos,id',
        ]);

        $transaction = Transaction::find($id);
        if($request->input('datetime'))
        {
            $transaction->waktu = $request->input('datetime');
        }
        if($request->input('noMeja'))
        {
            $transaction->noMeja = $request->input('noMeja');
        }
        if($request->input('notes'))
        {
            $transaction->keterangan = $request->input('notes');
        }
        if($request->input('total_price'))
        {
            $transaction->hargaTotal = $request->input('total_price');
        }
        if($request->input('promo'))
        {
            $transaction->promo_id = $request->input('promo');
        }
        if ($request->input('reservation_status'))
        {
            $transaction->statusTransaksi = $request->input('reservation_status');
        }
        $transaction->save();

        $orders = Order::where('transaction_id', '=', $id)->get();
        foreach($orders as $order)
        {
            $order->delete();
        }

        for ($i = 0; $i < count($request->input('menu_ids')); $i++) {
            Order::create([
                'quantity' => json_decode($request->input('quantities')[$i])[0],
                'transaction_id' => $transaction->id,
                'menu_id' => json_decode($request->input('menu_ids')[$i])[0],
            ]);
        }

        Cache::forget('transactions');
        return redirect()->route('transaction.index')->with('success', 'Transaction has been updated');    
    }

    public function detail($id)
    {
        $transaction = Cache::remember('transactions:' . $id, 120, function () use ($id) {
            return Transaction::findOrFail($id);
        });
        $orders = Cache::remember('orders:' . $id, 120, function () use ($id) {
            return Order::where('transaction_id', '=', $id)->get();
        });

        $location = Location::findOrFail($transaction->location_id);
        $transaction->alamat = $location->alamat;

        $member = User::findOrFail($transaction->user_id);
        $transaction->pemesan = $member->nama;

        $promo = Promo::findOrFail($transaction->promo_id);

        foreach($orders as $order)
        {
            $menu = Menu::findOrFail($order->menu_id);
            $order->nama = $menu->nama;
            $order->harga = $menu->harga;
        }

        if((Auth::user()->role != 'pemilik') && (Auth::user()->location_id != $transaction->location_id))
        {
            return redirect()->route('transaction.index')->with('success', 'You do not have permission to view this transaction');
        }

        return view('transaction.detail', compact('transaction', 'orders', 'promo'));
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        if((Auth::user()->role != 'pemilik') && (Auth::user()->location_id != $transaction->location_id))
        {   
            return redirect()->route('transaction.index')->with('success', 'You do not have permission to delete this reservation');
        }

        $transaction->delete();
        return redirect()->route('transaction.index')->with('success', 'Reservation deleted successfully');
    }
}