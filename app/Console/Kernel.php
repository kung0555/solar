<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AdminController;



class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected $commands = [
        Commands\ScheduleBilling::class, 
    ];
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        // $schedule->command('cron:billingdaily')->everyMinute()->runInBackground()->timezone('Asia/Bangkok'); //แก้ไขบรรนี้เพื่อ เพื่อกำหนดความถี่ ในการทำงานของ command
        // $schedule->exec('node /admin/billing/billingAuto')->everyMinute()->timezone('Asia/Bangkok')->runInBackground(); 
        // $schedule->command('cron:billingdaily')->everyMinute();

       

        $contract = DB::table('contracts')->orderBy('id', 'desc')->first();
        $date = $contract->date_billing;
        // echo $date;
        // $schedule->command('cron:billingdaily')->monthlyOn($date, '22:17')->withoutOverlapping();
        $schedule->command('cron:billingdaily')->everyMinute()->withoutOverlapping();

        // $schedule->call(function () {
        //     $AdminController = new AdminController;
        //     $AdminController->sendmail();
        // })->everyMinute();
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
