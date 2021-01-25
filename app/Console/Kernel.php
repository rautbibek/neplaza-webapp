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
        commands\RepordedAdDelete::class,
        commands\CheckUrgentProduct::class,
        commands\CheckFeaturedProduct::class,
        commands\FeatureNotification::class,
        commands\UrgentNotification::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->command('feature:update')->dailyAt('10:00');;
         $schedule->command('expire:feature')->dailyAt('10:15');;
         $schedule->command('expire:urgent')->dailyAt('10:40');;
         $schedule->command('urgent:update')->dailyAt('11:00');;
         $schedule->command('urgent:update')->daily('11:20');
         $schedule->command('reported')->dailyAt('11:40');;
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
