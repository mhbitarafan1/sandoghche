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
        Commands\runLotsThisTime::class,
        Commands\sendInstallmentReminds::class,
        Commands\calculatePointsOfUsers::class,

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
        // $schedule->command('runLotsThisTime:hourly')->hourlyAt(1);
        $schedule->command('runLotsThisTime:hourly')->hourly();
        $schedule->command('sendInstallmentReminds:daily')->dailyAt("17:00");
        $schedule->command('calculatePointsOfUsers:monthly')->monthlyOn(1,"3:0");

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
