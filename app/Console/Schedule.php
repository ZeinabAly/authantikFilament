<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule as ScheduleContract;

class Schedule
{
    /**
     * Define the application's command schedule.
     */
    public function __invoke(ScheduleContract $schedule): void
    {
        $schedule->call(function() {
            info('Called every minute');
        })->everyMinute()->name('log-message');
    }
}