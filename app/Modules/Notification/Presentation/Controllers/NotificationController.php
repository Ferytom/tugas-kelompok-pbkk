<?php

namespace App\Modules\Notification\Presentation\Controllers;

use App\Modules\Notification\Core\Application\Service\NotificationService;

class NotificationController
{
    private $formData = [];
    private $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index()
    {
        $notifications = $this->notificationService->getNotification();
        
        return view('notification::index', compact('notifications'));
    }
}
