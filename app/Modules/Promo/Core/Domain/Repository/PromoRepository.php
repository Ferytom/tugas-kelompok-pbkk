<?php

namespace App\Modules\Promo\Core\Domain\Repository;

use App\Modules\Shared\Core\Domain\Model\Promo;
use Illuminate\Database\Eloquent\Collection;

interface PromoRepository
{
    public function getAllExpiredPromos(): Collection;

    public function getAllActivePromos(): Collection;

    public function getPromoById(int $promoId): Promo;

    public function createPromo(array $data): Promo;

    public function updatePromo(int $promoId, array $data): Promo;

    public function deletePromo(int $promoId): void;
}
