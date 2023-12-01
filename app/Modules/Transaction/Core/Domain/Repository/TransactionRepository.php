<?php

namespace App\Modules\Transaction\Core\Domain\Repository;

use App\Modules\Shared\Core\Domain\Model\Order;
use Illuminate\Database\Eloquent\Collection;
use App\Modules\Shared\Core\Domain\Model\Transaction;
use App\Modules\Shared\Core\Domain\Model\Promo;
use Illuminate\Support\Facades\Auth;

interface TransactionRepository
{
    public function getOngoingTransactions(): Collection;

    public function getAllLocations(): Collection;
    
    public function getAllPromos(): Collection;

    public function getAllMenus(): Collection;

    public function getAllMembers(): Collection;

    public function getTransactionById(int $transactionId): Transaction;

    public function getOrdersById(int $transactionId): Collection;

    public function getPromoById(int $transactionId): Promo;

    public function createTransaction(array $data): Transaction;

    public function createOrder(array $data): Order;
    
    public function updateTransaction(int $transactionId, array $data): Transaction;

    public function deleteTransaction(int $transactionid): void;

    public function deleteOrder(int $transactionId): void;
}
