<?php

namespace App\Modules\Promo\Core\Application\Service;

use App\Modules\Promo\Core\Domain\Repository\PromoRepository;
use App\Modules\Shared\Core\Domain\Model\Promo;
use Illuminate\Database\Eloquent\Collection;

class PromoService
{
    private $promoRepository;

    public function __construct(PromoRepository $promoRepository)
    {
        $this->promoRepository = $promoRepository;
    }

    public function getAllActivePromos(): Collection
    {
        return $this->promoRepository->getAllActivePromos();
    }
    
    public function getAllExpiredPromos(): Collection
    {
        return $this->promoRepository->getAllExpiredPromos();
    }

    public function createPromo($data): Promo
    {
        return $this->promoRepository->createPromo($data);
    }

    public function getPromoById($promoId): Promo
    {
        return $this->promoRepository->getPromoById($promoId);
    }

    public function updatePromo($promoId, $data): Promo
    {
        return $this->promoRepository->updatePromo($promoId, $data);
    }

    public function deletePromo($promoId): void
    {
        $this->promoRepository->deletePromo($promoId);
    }
}

