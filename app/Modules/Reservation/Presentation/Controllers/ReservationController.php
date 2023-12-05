<?php

namespace App\Modules\Reservation\Presentation\Controllers;

use App\Modules\Reservation\Core\Application\Service\ReservationService;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservationController
{
    private $formData = [];
    private $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    public function index()
    {
        $completed_reservations = $this->reservationService->getCompletedReservations();
        $ongoing_reservations = $this->reservationService->getOngoingReservations();
        $expired_reservations = $this->reservationService->getExpiredReservations();
        $locations = $this->reservationService->getAllLocations();

        foreach($ongoing_reservations as $reservation)
        {
            $reservation->currentDate = Carbon::now('Asia/Bangkok')->startOfDay();
        }

        return view('reservation::index', compact('completed_reservations', 'ongoing_reservations', 'expired_reservations', 'locations'));
    }

    public function create()
    {
        $locations = $this->reservationService->getAllLocations();

        $menus = $this->reservationService->getAllMenus();

        $promos = $this->reservationService->getAllPromos();

        return view ('reservation::create', compact('locations', 'menus', 'promos'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'required|exists:locations,id',
            'datetime' => function ($attribute, $value, $failed) {
                if (Carbon::parse($value) < Carbon::now()->addDay()->startOfDay()) {
                    $failed('Reservation must be made at least 1 day prior.');
                }
                if (Carbon::parse($value)->hour < 8 || Carbon::parse($value)->hour > 21) {
                    $failed('The time must be between 8 AM and 9 PM.');
                }
            },
            'total_price' => 'required|numeric',
            'notes' => 'nullable|string',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $data = [
            'waktu' => $request->input('datetime'),
            'noMeja' => 1,
            'keterangan' => $request->input('notes'),
            'hargaTotal' => $request->input('total_price'),
            'statusTransaksi' => "Belum Dimulai",
            'isReservasi' => True,
            'promo_id' => $request->input('promo'),
            'user_id' => Auth::user()->id,
            'location_id' => $request->input('address'),
        ];

        $reservation = $this->reservationService->createReservation($data);

        for ($i = 0; $i < $request->input('menu_count'); $i++) {
            $orderData = [
                'quantity' => json_decode($request->input('quantities')[0])[$i],
                'transaction_id' => $reservation->id,
                'menu_id' => json_decode($request->input('menu_ids')[0])[$i],
            ];
            $this->reservationService->createOrder($orderData);
        }

        Cache::forget('completed_reservations');
        Cache::forget('expired_reservations');
        Cache::forget('ongoing_reservations');
        Cache::forget('ongoingTransactions');
        Cache::forget('completedTransactions');
        Cache::forget('notifications');

        return redirect()->route('reservation.index')->with('success', 'Reservation created successfully');
    }

    public function edit($id)
    {
        $reservation = $this->reservationService->getReservationById($id);
        $orders = $this->reservationService->getOrdersById($id);
        $locations = $this->reservationService->getAllLocations();
        $menus = $this->reservationService->getAllMenus();
        $promos = $this->reservationService->getAllPromos();

        if(((Auth::user()->role == 'pelanggan') && (Auth::user()->id != $reservation->user_id)) || ((Auth::user()->role != 'pelanggan') && (Auth::user()->role != 'pemilik') && (Auth::user()->location_id != $reservation->location_id)))
        {
            return redirect()->route('reservation.index')->with('error', 'You do not have permission to edit this reservation');
        }

        $currentDate = Carbon::now('Asia/Bangkok');
        $reservationDate = Carbon::parse($reservation->waktu);

        $hoursDifference = $currentDate->diffInHours($reservationDate);

        if (((Auth::user()->role == 'pelanggan')) && ($hoursDifference < 24)) {
            return redirect()->route('reservation.index')->with('error', 'You can only edit this reservation until H-24 hours');
        }

        return view('reservation::edit', compact('reservation', 'orders', 'locations', 'menus', 'promos'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'exists:locations,id',
            'noMeja' => 'numeric',
            'datetime' => function ($attribute, $value, $failed) {
                if ((Auth::user()->role == 'pelanggan') && (Carbon::parse($value) < Carbon::now()->addDay()->startOfDay())) {
                    $failed('The date must be in the future.');
                }
                if (Carbon::parse($value)->hour < 8 || Carbon::parse($value)->hour > 21) {
                    $failed('The time must be between 8 AM and 9 PM.');
                }
            },
            'total_price' => 'numeric',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $reservation = $this->reservationService->getReservationById($id);

        if(((Auth::user()->role == 'pelanggan') && (Auth::user()->id != $reservation->user_id)) || ((Auth::user()->role != 'pelanggan') && (Auth::user()->role != 'pemilik') && (Auth::user()->location_id != $reservation->location_id)))
        {
            return redirect()->route('reservation.index')->with('error', 'You do not have permission to edit this reservation');
        }

        $currentDate = Carbon::now('Asia/Bangkok');
        $reservationDate = Carbon::parse($reservation->waktu);

        $hoursDifference = $currentDate->diffInHours($reservationDate);

        if (((Auth::user()->role == 'pelanggan')) && ($hoursDifference < 24)) {
            return redirect()->route('reservation.index')->with('success', 'You can only edit this reservation until H-24 hours');
        }

        $data = [
            'waktu' => $request->input('datetime', $reservation->waktu),
            'noMeja' => $request->input('noMeja', $reservation->noMeja),
            'keterangan' => $request->input('notes', $reservation->keterangan),
            'hargaTotal' => $request->input('total_price', $reservation->hargaTotal),
            'statusTransaksi' => $request->input('reservation_status', $reservation->statusTransaksi),
            'isReservasi' => True,
            'promo_id' => $request->input('promo', $reservation->promo),
            'user_id' => $reservation->user_id,
            'location_id' => $request->input('address', $reservation->location_id),
        ];
        
        $this->reservationService->updateReservation($id, $data);

        $this->reservationService->deleteOrder($id);

        for ($i = 0; $i < $request->input('menu_count'); $i++) {
            $orderData = [
                'quantity' => json_decode($request->input('quantities')[0])[$i],
                'transaction_id' => $id,
                'menu_id' => json_decode($request->input('menu_ids')[0])[$i],
            ];
            $this->reservationService->createOrder($orderData);
        }

        Cache::forget('completed_reservations');
        Cache::forget('expired_reservations');
        Cache::forget('ongoing_reservations');
        Cache::forget('ongoingTransactions');
        Cache::forget('completedTransactions');
        Cache::forget('transactions:' . $id);
        Cache::forget('orders: ' . $id);
        Cache::forget('notifications');
        
        return redirect()->route('reservation.index')->with('success', 'Reservation has been updated');    
    }

    public function detail($id)
    {
        $reservation = $this->reservationService->getReservationById($id);
        $orders = $this->reservationService->getOrdersById($id);

        $promo = $this->reservationService->getPromoById($id);

        if(((Auth::user()->role == 'pelanggan') && (Auth::user()->id != $reservation->user_id)) || ((Auth::user()->role != 'pelanggan') && (Auth::user()->role != 'pemilik') && (Auth::user()->location_id != $reservation->location_id)))
        {
            return redirect()->route('reservation.index')->with('error', 'You do not have permission to view this reservation');
        }

        return view('reservation::detail', compact('reservation', 'orders', 'promo'));
    }

    public function destroy($id)
    {
        $reservation = $this->reservationService->getReservationById($id);
        if((Auth::user()->role == 'pemilik') || ((Auth::user()->role == 'pelanggan') && (Auth::user()->id != $reservation->user_id)))
        {
            $currentDate = Carbon::now('Asia/Bangkok');
            $reservationDate = Carbon::parse($reservation->waktu);

            $hoursDifference = $currentDate->diffInHours($reservationDate);

            if (((Auth::user()->role == 'pelanggan')) && ($hoursDifference < 24)) {
                return redirect()->route('reservation.index')->with('error', 'You can only delete this reservation until H-24 hours');
            }
            
            $this->reservationService->deleteOrder($id);
            $this->reservationService->deleteReservation($id);

            Cache::forget('completed_reservations');
            Cache::forget('expired_reservations');
            Cache::forget('ongoing_reservations');
            Cache::forget('ongoingTransactions');
            Cache::forget('completedTransactions');
            Cache::forget('transactions:' . $id);
            Cache::forget('orders: ' . $id);

            return redirect()->route('reservation.index')->with('success', 'Reservation deleted successfully');
        }
        return redirect()->route('reservation.index')->with('error', 'You do not have permission to delete this reservation');
    }
}