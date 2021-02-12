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
         $schedule->command('feature:update')->timezone('Asia/Kathmandu')->runInBackground();
        // $schedule->command('expire:feature')->timezone('Asia/Kathmandu')->dailyAt('22:15');
         //$schedule->command('expire:urgent')->timezone('Asia/Kathmandu')->dailyAt('22:40');
         $schedule->command('urgent:update')->timezone('Asia/Kathmandu')->runInBackground();
         //$schedule->command('reported')->timezone('Asia/Kathmandu')->dailyAt('23:40');
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
