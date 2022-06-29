<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use App\Http\Controllers\AdminController;

class ScheduleBilling extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'command:name'; ($signature ชื่อสำหรับเรียกใช้ command)
    protected $signature = 'cron:billingdaily';

    // public function __construct()
    // {
    //     parent::__construct();
    // }

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Billing';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        // $AdminController = new AdminController;
        // $AdminController->billingAuto();
        
        // $data["email"] = "benchapol@pico.co.th";
        // $data["title"] = date('H:i:s');
        // $data["body"] = "This is for testing email using smtp.";

        // Mail::send('mailForm.billingSendEmail', compact('data'), function ($message) use ($data) {
        //     $message->to($data["email"])
        //         ->subject($data["title"]);
        // });

        
        $AdminController = new AdminController;
        if ($AdminController->billingAuto()) {

            $data["email"] = "benchapol@pico.co.th";
            $data["title"] = "บิลค่าไฟประจำเดือน True server ".date('H:i:s');
            $data["body"] = "This is for testing email using smtp.";

            Mail::send('mailForm.billingSendEmail', compact('data'), function ($message) use ($data) {
                $message->to($data["email"])
                    ->subject($data["title"]);
            });
        } else {
            $data["email"] = "benchapol@pico.co.th";
            $data["title"] = "บิลค่าไฟประจำเดือน False server " .date('H:i:s');
            $data["body"] = "This is for testing email using smtp.";

            Mail::send('mailForm.billingSendEmail', compact('data'), function ($message) use ($data) {
                $message->to($data["email"])
                    ->subject($data["title"]);
            });
        }
    }
}
