<?php

namespace App\Modules\Waitlist\Core\Application\Service;

use App\Modules\Shared\Core\Domain\Model\User;
use App\Modules\Waitlist\Core\Domain\Repository\WaitlistRepository;
use App\Modules\Shared\Core\Domain\Model\Waitlist;
use Illuminate\Database\Eloquent\Collection;

class WaitlistService
{
    private $waitlistRepository;

    public function __construct(WaitlistRepository $waitlistRepository)
    {
        $this->waitlistRepository = $waitlistRepository;
    }

    public function getAllWaitlists(): Collection
    {
        return $this->waitlistRepository->getAllWaitlists();
    }
    public function getAllLocations(): Collection
    {
        return $this->waitlistRepository->getAllLocations();
    }

    public function getWaitlistById(int $waitlistId): Waitlist
    {
        return $this->waitlistRepository->getWaitlistById($waitlistId);
    }

    public function createWaitlist(array $data): Waitlist
    {
        return $this->waitlistRepository->createWaitlist($data);
    }

    public function deleteWaitlist(int $waitlistId): void
    {
        $this->waitlistRepository->deleteWaitlist($waitlistId);
    }
}

