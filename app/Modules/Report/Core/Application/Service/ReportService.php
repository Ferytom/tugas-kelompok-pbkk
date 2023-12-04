<?php

namespace App\Modules\Report\Core\Application\Service;

use App\Modules\Report\Core\Domain\Repository\ReportRepository;
use Illuminate\Database\Eloquent\Collection;

class ReportService
{
    private $reportRepository;

    public function __construct(ReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function getCompletedTransactions(): Collection
    {
        return $this->reportRepository->getCompletedTransactions();
    }

    public function getDailyReport(): Collection
    {
        return $this->reportRepository->getDailyReport();
    }
    
    public function getMonthlyReport(): Collection
    {
        return $this->reportRepository->getMonthlyReport();
    }

    public function getHighestTransaction(): Collection
    {
        return $this->reportRepository->getHighestTransaction();
    }

    public function getBestMember(): Collection
    {
        return $this->reportRepository->getBestMember();
    }

    public function getBestLocation(): Collection
    {
        return $this->reportRepository->getBestLocation();
    }

    public function getBestFood(): Collection
    {
        return $this->reportRepository->getBestFood();
    }

    public function getTotalIncome(Collection $groupedTransactions): Collection
    {
        return $this->reportRepository->getTotalIncome($groupedTransactions);
    }
}

