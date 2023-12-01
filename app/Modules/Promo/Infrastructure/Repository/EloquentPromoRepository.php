<?php

namespace App\Modules\Promo\Infrastructure\Repository;
use App\Modules\Promo\Core\Domain\Repository\PromoRepository;
use App\Modules\Shared\Core\Domain\Model\Promo;
use Cache;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use App\Modules\Shared\Core\Domain\Model\Menu;
use Illuminate\Database\Eloquent\Collection;


class EloquentPromoRepository implements PromoRepository
{
    public function getAllExpiredPromos(): Collection
    {
        $expired_promos = Cache::remember('expired_promos', 120, function () {
            $current_date = Carbon::now('Asia/Bangkok');
            return Promo::where('expired', '<', $current_date)->get();
        });

        return $expired_promos;
    }

    public function getAllActivePromos(): Collection
    {
        $active_promos = Cache::remember('active_promos', 120, function () {
            $current_date = Carbon::now()->format('Y-m-d');
            return Promo::where('expired', '>=', $current_date)->get();
        });

        return $active_promos;
    }

    public function createPromo(array $data): Promo
    {
        return Promo::create($data);
    }

    public function getPromoById(int $promoId): Promo
    {
        $promo = Promo::findOrFail($promoId);
        return $promo;
    }

    public function updatePromo(int $promoId, array $data): Promo
    {
        $promo = Promo::findOrFail($promoId);
        $promo->update($data);
        return $promo;
    }

    public function deletePromo(int $promoId): void
    {
        Promo::destroy($promoId);
    }
}
