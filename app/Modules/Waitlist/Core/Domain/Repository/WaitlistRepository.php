<?php

namespace App\Modules\Waitlist\Core\Domain\Repository;

use App\Modules\Shared\Core\Domain\Model\User;
use App\Modules\Shared\Core\Domain\Model\Waitlist;
use Illuminate\Database\Eloquent\Collection;

interface WaitlistRepository
{
    public function getAllWaitlists(): Collection;

    public function getAllLocations(): Collection;

    public function getWaitlistById(int $waitlistId): Waitlist;

    public function createWaitlist(array $data): Waitlist;

    public function deleteWaitlist(int $waitlistId): void;
}