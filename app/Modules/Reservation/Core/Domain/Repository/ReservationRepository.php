<?php

namespace App\Modules\Reservation\Core\Domain\Repository;

use App\Modules\Shared\Core\Domain\Model\Order;
use Illuminate\Database\Eloquent\Collection;
use App\Modules\Shared\Core\Domain\Model\Transaction;
use App\Modules\Shared\Core\Domain\Model\Promo;
use Illuminate\Support\Facades\Auth;

interface ReservationRepository
{
    public function getCompletedReservations(): Collection;

    public function getOngoingReservations(): Collection;

    public function getExpiredReservations(): Collection;

    public function getAllLocations(): Collection;
    
    public function getAllPromos(): Collection;
    
    public function getAllMenus(): Collection;

    public function getReservationById(int $reservationId): Transaction;

    public function getOrdersById(int $reservationId): Collection;

    public function getPromoById(int $reservationId): Promo;

    public function createReservation(array $data): Transaction;

    public function createOrder(array $data): Order;
    
    public function updateReservation(int $reservationId, array $data): Transaction;

    public function deleteReservation(int $reservationId): void;

    public function deleteOrder(int $reservationId): void;
}
