<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\ReplicadoDailySyncCommand;
use App\Console\Commands\ReplicadoWeeklySyncCommand;
use App\Console\Commands\ReplicadoLattesSyncCommand;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $emails = explode(',',config('app.mails_to_send_logs'));

        $schedule->command(ReplicadoDailySyncCommand::class)
            ->daily()
            ->emailOutputOnFailure(config('mail.from.address'));

        $schedule->command(ReplicadoWeeklySyncCommand::class)
            ->weekly()
            ->emailOutputOnFailure(config('mail.from.address'));

        $schedule->command(ReplicadoLattesSyncCommand::class)
            ->weekly()
            ->emailOutputOnFailure(config('mail.from.address'));
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
