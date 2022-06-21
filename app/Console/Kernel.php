<?php

namespace App\Console;

use App\Mail\TourInvitation;
use App\Models\TourInvitations;
use App\Models\UsergroupInvitations;
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
        // $schedule->command('inspire')->hourly();
        //Каждую минуту проверяем очередь отправки в группы и в туры
        $schedule->call(function () {
            //Отправка в телегу и на почту
            UsergroupInvitations::sendInvitations();
            TourInvitations::sendInvitations();
        })->everyMinute();
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
