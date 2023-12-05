<?php

namespace App\Modules\Reservation\Infrastructure\Repository;
use App\Modules\Reservation\Core\Domain\Repository\ReservationRepository;
use App\Modules\Shared\Core\Domain\Model\Order;
use App\Modules\Shared\Core\Domain\Model\Transaction;
use App\Modules\Shared\Core\Domain\Model\User;
use App\Modules\Shared\Core\Domain\Model\Location;
use App\Modules\Shared\Core\Domain\Model\Promo;
use App\Modules\Shared\Core\Domain\Model\Menu;
use Cache;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class EloquentReservationRepository implements ReservationRepository
{
    public function getCompletedReservations(): Collection
    {
        if(Auth::user()->role == 'pemilik')
        {
            $completed_reservations = Cache::remember('completed_reservations', 120, function () {
                $current_date = Carbon::now('Asia/Bangkok');
                return Transaction::where('waktu', '<', $current_date)->where('statusTransaksi', '=', 'Selesai')->where('isReservasi', '=', True)->orderBy('waktu')->get();
            });
        } else if (Auth::user()->role == 'pelanggan')
        {
            $completed_reservations = Cache::remember('completed_reservations' . Auth::user()->id, 120, function () {
                $current_date = Carbon::now('Asia/Bangkok');
                return Transaction::where('waktu', '<', $current_date)->where('statusTransaksi', '=', 'Selesai')->where('isReservasi', '=', True)->where('user_id', '=', Auth::user()->id)->orderBy('waktu')->get();
            });
        } else
        {
            $completed_reservations = Cache::remember('completed_reservations' . Auth::user()->id, 120, function () {
                $current_date = Carbon::now('Asia/Bangkok');
                return Transaction::where('waktu', '<', $current_date)->where('statusTransaksi', '=', 'Selesai')->where('isReservasi', '=', True)->where('location_id', '=', Auth::user()->location_id)->orderBy('waktu')->get();
            });
        }

        foreach($completed_reservations as $reservation)
        {
            $member = User::findOrFail($reservation->user_id);
            $reservation->member = $member->nama;

            $location = Location::findOrFail($reservation->location_id);
            $reservation->address = $location->alamat;
        }

        return $completed_reservations;
    }

    public function getOngoingReservations(): Collection
    {
        if(Auth::user()->role == 'pemilik')
        {
            $ongoing_reservations = Cache::remember('ongoing_reservations', 120, function () {
                $current_date = Carbon::now('Asia/Bangkok');
                return Transaction::where('waktu', '>=', $current_date)->where('isReservasi', '=', True)->where('statusTransaksi', '=', 'Belum Dimulai')->orderBy('waktu')->get();
            });
        } else if(Auth::user()->role == 'pelanggan')
        {
            $ongoing_reservations = Cache::remember('ongoing_reservations'  . Auth::user()->id, 120, function () {
                $current_date = Carbon::now('Asia/Bangkok')->startOfDay();
                return Transaction::where('waktu', '>=', $current_date)->where('isReservasi', '=', True)->where('user_id', '=', Auth::user()->id)->orderBy('waktu')->get();
            });
        } else
        {
            $ongoing_reservations = Cache::remember('ongoing_reservations'  . Auth::user()->id, 120, function () {
                $current_date = Carbon::now('Asia/Bangkok')->startOfDay();
                return Transaction::where('waktu', '>=', $current_date)->where('isReservasi', '=', True)->where('statusTransaksi', '=', 'Belum Dimulai')->where('location_id', '=', Auth::user()->location_id)->orderBy('waktu')->get();
            });
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

            if ($hoursDifference > 24) {
                $reservation->editable = true;
            } else {
                $reservation->editable = false;
            }
        }

        return $ongoing_reservations;
    }

    public function getExpiredReservations(): Collection
    {
        if(Auth::user()->role == 'pemilik')
        {
            $expired_reservations = Cache::remember('expired_reservations', 120, function () {
                $current_date = Carbon::now('Asia/Bangkok')->startOfDay();
                return Transaction::where('waktu', '<', $current_date)->where('statusTransaksi', '!=', 'Selesai')->where('isReservasi', '=', True)->orderBy('waktu')->get();
            });
        } else if(Auth::user()->role == 'pelanggan')
        {
            $expired_reservations = Cache::remember('expired_reservations'  . Auth::user()->id, 120, function () {
                $current_date = Carbon::now('Asia/Bangkok')->startOfDay();
                return Transaction::where('waktu', '<', $current_date)->where('statusTransaksi', '!=', 'Selesai')->where('isReservasi', '=', True)->where('user_id', '=', Auth::user()->id)->orderBy('waktu')->get();
            });
        } else
        {
            $expired_reservations = Cache::remember('expired_reservations'  . Auth::user()->id, 120, function () {
                $current_date = Carbon::now('Asia/Bangkok')->startOfDay();
                return Transaction::where('waktu', '<', $current_date)->where('statusTransaksi', '!=', 'Selesai')->where('isReservasi', '=', True)->where('location_id', '=', Auth::user()->location_id)->orderBy('waktu')->get();
            });
        }

        foreach($expired_reservations as $reservation)
        {
            $member = User::findOrFail($reservation->user_id);
            $reservation->member = $member->nama;

            $location = Location::findOrFail($reservation->location_id);
            $reservation->address = $location->alamat;
        }

        return $expired_reservations;
    }

    public function getAllLocations(): Collection
    {
        if(Auth::user()->role == 'pemilik')
        {
            $locations = Cache::remember('locations', 120, function () {
                return Location::all();
            });
        }
        else
        {
            $locations = Cache::remember('locations', 120, function () {
                return Location::where('id', '=', Auth::user()->location_id)->get();
            });
        }

        return $locations;
    }
    
    public function getAllPromos(): Collection
    {
        $promos = Cache::remember('promos', 120, function () {
            $current_date = Carbon::now()->format('Y-m-d');
            return Promo::where('expired', '>=', $current_date)->get();
        });

        return $promos;
    }
    
    public function getAllMenus(): Collection
    {
        $menus = Cache::remember('menus', 120, function () {
            return Menu::all();
        });

        return $menus;
    }

    public function getReservationById(int $reservationId): Transaction
    {
        $reservation = Transaction::findOrFail($reservationId);
        
        $location = Location::findOrFail($reservation->location_id);
        $reservation->alamat = $location->alamat;

        $member = User::findOrFail($reservation->user_id);
        $reservation->pemesan = $member->nama;

        return $reservation;
    }

    public function getOrdersById(int $reservationId): Collection
    {
        $orders = Cache::remember('orders:' . $reservationId, 120, function () use ($reservationId) {
            return Order::where('transaction_id', '=', $reservationId)->get();
        });

        foreach($orders as $order)
        {
            $menu = Menu::findOrFail($order->menu_id);
            $order->nama = $menu->nama;
            $order->harga = $menu->harga;
        }

        return $orders;
    }

    public function getPromoById(int $reservationId): Promo
    {
        $reservation = Transaction::findOrFail($reservationId);

        $promo = Promo::findOrFail($reservation->promo_id);

        return $promo;
    }

    public function createReservation(array $data): Transaction
    {
        return Transaction::create($data);
    }

    public function createOrder(array $data): Order
    {
        return Order::create($data);
    }
    
    public function updateReservation(int $reservationId, array $data): Transaction
    {
        $reservation = Transaction::findOrFail($reservationId);
        $reservation->update($data);
        return $reservation;
    }

    public function deleteReservation(int $reservationId): void
    {
        Transaction::destroy($reservationId);
    }

    public function deleteOrder(int $reservationId): void
    {
        $orders = Order::where('transaction_id', '=', $reservationId)->get();
        foreach($orders as $order)
        {
            $order->delete();
        }
    }
}
