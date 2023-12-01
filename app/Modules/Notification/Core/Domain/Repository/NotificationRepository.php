<?php

namespace App\Modules\Notification\Core\Domain\Repository;

use Illuminate\Database\Eloquent\Collection;

interface NotificationRepository
{
    public function getNotification(): Collection;
}
