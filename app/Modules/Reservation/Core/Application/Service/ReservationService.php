<?php

namespace App\Modules\Reservation\Core\Application\Service;

use App\Modules\Reservation\Core\Domain\Repository\ReservationRepository;
use App\Modules\Shared\Core\Domain\Model\Order;
use App\Modules\Shared\Core\Domain\Model\Promo;
use App\Modules\Shared\Core\Domain\Model\Transaction;
use Illuminate\Database\Eloquent\Collection;

class ReservationService
{
    private $reservationRepository;

    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    public function getCompletedReservations(): Collection
    {
        return $this->reservationRepository->getCompletedReservations();
    }

    public function getOngoingReservations(): Collection
    {
        return $this->reservationRepository->getOngoingReservations();
    }

    public function getExpiredReservations(): Collection
    {
        return $this->reservationRepository->getExpiredReservations();
    }

    public function getAllLocations(): Collection
    {
        return $this->reservationRepository->getAllLocations();
    }
    
    public function getAllPromos(): Collection
    {
        return $this->reservationRepository->getAllPromos();
    }

    public function getAllMenus(): Collection
    {
        return $this->reservationRepository->getAllMenus();
    }

    public function getReservationById(int $reservationId): Transaction
    {
        return $this->reservationRepository->getReservationById($reservationId);
    }

    public function getOrdersById(int $reservationId): Collection
    {
        return $this->reservationRepository->getOrdersById($reservationId);
    }

    public function getPromoById(int $reservationId): Promo
    {
        return $this->reservationRepository->getPromoById($reservationId);
    }

    public function createReservation(array $data): Transaction
    {
        return $this->reservationRepository->createReservation($data);
    }

    public function createOrder(array $data): Order
    {
        return $this->reservationRepository->createOrder($data);
    }
    
    public function updateReservation(int $reservationId, array $data): Transaction
    {
        return $this->reservationRepository->updateReservation($reservationId, $data);
    }

    public function deleteReservation(int $reservationId): void
    {
        $this->reservationRepository->deleteReservation($reservationId);
    }

    public function deleteOrder(int $reservationId): void
    {
        $this->reservationRepository->deleteOrder($reservationId);
    }
}

