<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\FormatData',
        'App\Console\Commands\FacilitiesInRange',
        'App\Console\Commands\FacilityDistance',
        'App\Console\Commands\CalculateTravelMethods',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('atoms:range')->hourly()->emailOutputTo('jason@dossweb.com');
        $schedule->command('atoms:range --demo')->hourly()->emailOutputTo('jason@dossweb.com');
        $schedule->command('atoms:distance')->hourlyAt(5)->emailOutputTo('jason@dossweb.com');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
