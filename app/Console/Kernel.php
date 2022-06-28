<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected $commands = [
        Commands\ScheduleBilling::class, //แก้ไขบรรนี้เพื่อ class command ที่เราได้สร้างขึ้น, กรณีเรามีการสร้าง command หลายๆ command เราก็มาใส่เรียงต่อๆ
    ];
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        // $schedule->command('cron:billingdaily')->everyMinute()->runInBackground()->timezone('Asia/Bangkok'); //แก้ไขบรรนี้เพื่อ เพื่อกำหนดความถี่ ในการทำงานของ command
        // $schedule->exec('node /admin/billing/billingAuto')->everyMinute()->timezone('Asia/Bangkok')->runInBackground(); 
        $schedule->command('cron:billingdaily')->everyMinute();
        // $schedule->command('cron:billingdaily')->monthlyOn(4, '15:00');;
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
