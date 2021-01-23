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
         $schedule->command('feature:update')->everyTwoMinutes();
         //$schedule->command('expire:feature')->everyTwoMinutes();
         //$schedule->command('expire:urgent')->everyTwoMinutes();
         $schedule->command('urgent:update')->everyFiveMinutes();
         //$schedule->command('urgent:update')->daily('14:00');
         //$schedule->command('reported')->everyMinutes();
         
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
