<?php

namespace App\Modules\Report\Presentation\Controllers;

use App\Modules\Report\Core\Application\Service\ReportService;
use Cache;
use Illuminate\Http\Request;

class ReportController
{
    private $formData = [];
    private $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function index()
    {
        $transactions = $this->reportService->getCompletedTransactions();

        return view('report::index', compact('transactions'));
    }

    public function daily()
    {
        $groupedTransactions = $this->reportService->getDailyReport();

        $dailyTotals = $this->reportService->getTotalIncome($groupedTransactions);

        return view('report::daily', compact('groupedTransactions', 'dailyTotals'));
    }

    public function monthly()
    {
        $groupedTransactions = $this->reportService->getMonthlyReport();

        $monthlyTotals = $this->reportService->getTotalIncome($groupedTransactions);

        return view('report::monthly', compact('groupedTransactions', 'monthlyTotals'));
    }

    public function misc()
    {
        $highestTotalTransactions = $this->reportService->getHighestTransaction();

        $bestMembers = $this->reportService->getBestMember();

        $bestLocations = $this->reportService->getBestLocation();

        $bestFoods = $this->reportService->getBestFood();

        return view('report::misc', compact('highestTotalTransactions', 'bestMembers', 'bestLocations', 'bestFoods'));
    }
    
}
