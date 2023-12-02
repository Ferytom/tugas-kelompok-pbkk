<?php

namespace App\Console\Commands;

use App\Jobs\DeleteWaitlistEntry;
use Illuminate\Console\Command;

class ClearWaitlists extends Command
{
    protected $signature = 'clear:waitlists';
    protected $description = 'Clear waitlists table daily at 00:00 UTC+7';

    public function handle()
    {
        try {
            DeleteWaitlistEntry::dispatch();

            $this->info('DeleteWaitlistEntry dispatched successfully!');
        } catch (\Exception $e) {
            $this->error('An error occurred: ' . $e->getMessage());
        }
    }
}
