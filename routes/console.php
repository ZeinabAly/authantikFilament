<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


// Schedule::call(function() {
//     info('Called every minute');
// })->everyMinute()->name('log-message');

Schedule::command('rapport:journalier')->dailyAt('23:59');
