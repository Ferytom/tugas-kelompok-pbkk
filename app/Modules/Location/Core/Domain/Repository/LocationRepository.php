<?php

namespace App\Modules\Location\Core\Domain\Repository;

use App\Modules\Shared\Core\Domain\Model\Location;
use Illuminate\Database\Eloquent\Collection;

interface LocationRepository
{
    public function getAllLocations(): Collection;

    public function createLocation(array $data): Location;

    public function getLocationById(int $locaionId): Location;

    public function updateLocation(int $locationId, array $data): Location;

    public function deleteLocation(int $locationId): void;
}
