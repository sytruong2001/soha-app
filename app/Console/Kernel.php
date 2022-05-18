<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\ProcessUpdate;


class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

    protected $commands = [
        'App\Console\Commands\Rev_daily',
        'App\Console\Commands\Nru_daily',
        'App\Console\Commands\Dau_daily',
        'App\Console\Commands\DbBackup',
    ];
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('update:rev')->everyTenMinutes()->timezone('Asia/Ho_Chi_Minh');
        $schedule->command('update:nru')->everyTenMinutes()->timezone('Asia/Ho_Chi_Minh');
        $schedule->command('update:dau')->everyTenMinutes()->timezone('Asia/Ho_Chi_Minh');
        $schedule->command('backup:db')->dailyAt("03:00")->timezone('Asia/Ho_Chi_Minh');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}