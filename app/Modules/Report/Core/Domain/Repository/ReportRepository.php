<?php

namespace App\Modules\Report\Core\Domain\Repository;

use Illuminate\Database\Eloquent\Collection;

interface ReportRepository
{
    public function getCompletedTransactions(): Collection;

    public function getDailyReport(): Collection;
    
    public function getMonthlyReport(): Collection;

    public function getHighestTransaction(): Collection;

    public function getBestMember(): Collection;

    public function getBestLocation(): Collection;

    public function getBestFood(): Collection;

    public function getTotalIncome(Collection $groupedTransactions): Collection;
}
