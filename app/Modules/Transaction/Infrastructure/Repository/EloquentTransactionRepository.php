<?php

namespace App\Modules\Transaction\Infrastructure\Repository;
use App\Modules\Transaction\Core\Domain\Repository\TransactionRepository;
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

class EloquentTransactionRepository implements TransactionRepository
{
    public function getOngoingTransactions(): Collection
    {
        if(Auth::user()->role == 'pemilik')
        {
            $transactions = Cache::remember('ongoingTransactions', 120, function () {
                return Transaction::where('statusTransaksi', '=', 'Sedang Berjalan')->orderBy('waktu')->get();
            });
        }
        else
        {
            $transactions = Cache::remember('ongoingTransactions', 120, function () {
                return Transaction::where('statusTransaksi', '=', 'Sedang Berjalan')->where('location_id','=',Auth::user()->location_id)->orderBy('waktu')->get();
            });
        }

        foreach($transactions as $transaction)
        {
            $location = Location::findOrFail($transaction->location_id);
            $transaction->address = $location->alamat;
        }

        return $transactions;
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
            return Promo::all();
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

    public function getAllMembers(): Collection
    {
        $members = Cache::remember('members', 120, function() {
            return User::where('role', '=', 'pelanggan')->get();
        });

        return $members;
    }

    public function getTransactionById(int $transactionId): Transaction
    {
        $transaction = Transaction::findOrFail($transactionId);
        
        $location = Location::findOrFail($transaction->location_id);
        $transaction->alamat = $location->alamat;

        $member = User::findOrFail($transaction->user_id);
        $transaction->pemesan = $member->nama;

        return $transaction;
    }

    public function getOrdersById(int $transactionId): Collection
    {
        $orders = Cache::remember('orders:' . $transactionId, 120, function () use ($transactionId) {
            return Order::where('transaction_id', '=', $transactionId)->get();
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

    public function createTransaction(array $data): Transaction
    {
        return Transaction::create($data);
    }

    public function createOrder(array $data): Order
    {
        return Order::create($data);
    }
    
    public function updateTransaction(int $transactionId, array $data): Transaction
    {
        $transaction = Transaction::findOrFail($transactionId);
        $transaction->update($data);
        return $transaction;
    }

    public function deleteTransaction(int $transactionId): void
    {
        Transaction::destroy($transactionId);
    }

    public function deleteOrder(int $transactionId): void
    {
        $orders = Order::where('transaction_id', '=', $transactionId)->get();
        foreach($orders as $order)
        {
            $order->delete();
        }
    }
}
