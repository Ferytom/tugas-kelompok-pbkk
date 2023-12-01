<?php

namespace App\Modules\Notification\Core\Application\Service;

use App\Modules\Notification\Core\Domain\Repository\NotificationRepository;
use Illuminate\Database\Eloquent\Collection;

class NotificationService
{
    private $notificationRepository;

    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function getNotification(): Collection
    {
        return $this->notificationRepository->getNotification();
    }
}

