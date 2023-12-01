<?php

namespace App\Modules\Transaction\Core\Application\Service;

use App\Modules\Transaction\Core\Domain\Repository\TransactionRepository;
use App\Modules\Shared\Core\Domain\Model\Order;
use App\Modules\Shared\Core\Domain\Model\Promo;
use App\Modules\Shared\Core\Domain\Model\Transaction;
use Illuminate\Database\Eloquent\Collection;

class TransactionService
{
    private $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function getOngoingTransactions(): Collection
    {
        return $this->transactionRepository->getOngoingTransactions();
    }

    public function getAllLocations(): Collection
    {
        return $this->transactionRepository->getAllLocations();
    }
    
    public function getAllPromos(): Collection
    {
        return $this->transactionRepository->getAllPromos();
    }

    public function getAllMenus(): Collection
    {
        return $this->transactionRepository->getAllMenus();
    }

    public function getAllMembers(): Collection
    {
        return $this->transactionRepository->getAllMembers();
    }

    public function getTransactionById(int $transactionId): Transaction
    {
        return $this->transactionRepository->getTransactionById($transactionId);
    }

    public function getOrdersById(int $transactionId): Collection
    {
        return $this->transactionRepository->getOrdersById($transactionId);
    }

    public function getPromoById(int $transactionId): Promo
    {
        return $this->transactionRepository->getPromoById($transactionId);
    }

    public function createTransaction(array $data): Transaction
    {
        return $this->transactionRepository->createTransaction($data);
    }

    public function createOrder(array $data): Order
    {
        return $this->transactionRepository->createOrder($data);
    }
    
    public function updateTransaction(int $transactionId, array $data): Transaction
    {
        return $this->transactionRepository->updateTransaction($transactionId, $data);
    }

    public function deleteTransaction(int $transactionid): void
    {
        $this->transactionRepository->deleteTransaction($transactionid);
    }

    public function deleteOrder(int $transactionId): void
    {
        $this->transactionRepository->deleteOrder($transactionId);
    }
}