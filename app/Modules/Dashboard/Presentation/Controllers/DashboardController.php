<?php

namespace App\Modules\Dashboard\Presentation\Controllers;

use App\Modules\Dashboard\Core\Application\Service\DashboardService;
use Cache;
use Illuminate\Http\Request;

class DashboardController
{
    private $formData = [];
    private $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $locations = $this->dashboardService->getAllLocations();

        return view('dashboard::index', compact('locations'));
    }
}
