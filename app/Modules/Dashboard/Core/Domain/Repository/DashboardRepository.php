<?php

namespace App\Modules\Dashboard\Core\Domain\Repository;

use App\Modules\Shared\Core\Domain\Model\Location;
use Illuminate\Database\Eloquent\Collection;

interface DashboardRepository
{

    public function getAllLocations(): Collection;
}