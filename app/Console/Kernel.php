<?php

namespace App\Console;

use App\Console\Commands\ClearWaitlists;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use DB;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('clear:waitlists')->dailyAt('00:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        foreach (scandir($path = app_path('Modules')) as $dir) {
            if (file_exists($folder_path = "{$path}/{$dir}/Presentation/Commands")) {
                $this->load($folder_path);
            }
        }

        require base_path('routes/console.php');
    }
}
