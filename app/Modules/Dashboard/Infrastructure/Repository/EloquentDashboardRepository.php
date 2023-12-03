<?php

namespace App\Modules\Dashboard\Infrastructure\Repository;
use App\Modules\Dashboard\Core\Domain\Repository\DashboardRepository;
use App\Modules\Shared\Core\Domain\Model\Location;
use Cache;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Modules\Shared\Core\Domain\Model\Menu;
use Illuminate\Database\Eloquent\Collection;


class EloquentDashboardRepository implements DashboardRepository
{
    public function getAllLocations(): Collection
    {
        $locations = Cache::remember('locations', 120, function () {
            return Location::all();
        });
        return $locations;
    }
}
