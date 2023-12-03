<?php

namespace App\Providers;

use App\Modules\Dashboard\Core\Domain\Repository\DashboardRepository;
use App\Modules\Dashboard\Infrastructure\Repository\EloquentDashboardRepository;
use App\Modules\Employee\Core\Domain\Repository\EmployeeRepository;
use App\Modules\Employee\Infrastructure\Repository\EloquentEmployeeRepository;
use App\Modules\Location\Core\Domain\Repository\LocationRepository;
use App\Modules\Location\Infrastructure\Repository\EloquentLocationRepository;
use App\Modules\Member\Core\Domain\Repository\MemberRepository;
use App\Modules\Member\Infrastructure\Repository\EloquentMemberRepository;
use App\Modules\Menu\Core\Domain\Repository\MenuRepository;
use App\Modules\Menu\Infrastructure\Repository\EloquentMenuRepository;
use App\Modules\Promo\Infrastructure\Repository\EloquentPromoRepository;
use App\Modules\Notification\Core\Domain\Repository\NotificationRepository;
use App\Modules\Notification\Infrastructure\Repository\EloquentNotificationRepository;
use App\Modules\Promo\Core\Domain\Repository\PromoRepository;
use App\Modules\Report\Core\Domain\Repository\ReportRepository;
use App\Modules\Report\Infrastructure\Repository\EloquentReportRepository;
use App\Modules\Reservation\Core\Domain\Repository\ReservationRepository;
use App\Modules\Reservation\Infrastructure\Repository\EloquentReservationRepository;
use App\Modules\Transaction\Core\Domain\Repository\TransactionRepository;
use App\Modules\Transaction\Infrastructure\Repository\EloquentTransactionRepository;
use App\Modules\Waitlist\Core\Domain\Repository\WaitlistRepository;
use App\Modules\Waitlist\Infrastructure\Repository\EloquentWaitlistRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(EmployeeRepository::class, EloquentEmployeeRepository::class);
        $this->app->bind(MemberRepository::class, EloquentMemberRepository::class);
        $this->app->bind(MenuRepository::class, EloquentMenuRepository::class);
        $this->app->bind(NotificationRepository::class, EloquentNotificationRepository::class);
        $this->app->bind(PromoRepository::class, EloquentPromoRepository::class);
        $this->app->bind(ReportRepository::class, EloquentReportRepository::class);
        $this->app->bind(ReservationRepository::class, EloquentReservationRepository::class);
        $this->app->bind(TransactionRepository::class, EloquentTransactionRepository::class);
        $this->app->bind(WaitlistRepository::class, EloquentWaitlistRepository::class);
        $this->app->bind(DashboardRepository::class, EloquentDashboardRepository::class);
        $this->app->bind(LocationRepository::class, EloquentLocationRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        foreach (scandir($path = app_path('Modules')) as $moduleDir) {
            View::addNamespace($moduleDir, "{$path}/{$moduleDir}/Presentation/views");
            Blade::componentNamespace("App\\Modules\\{$moduleDir}\\Presentation\\Components", $moduleDir);
        }
    }
}
