<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
// use Mail;

class ScheduleBilling extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'command:name'; ($signature ชื่อสำหรับเรียกใช้ command)
    protected $signature = 'cron:billingdaily';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Billing Daily';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        // $count_contract = DB::table('contracts')->orderBy('id', 'desc')->get()->count();

        
        // info("Cron Job running at " . now());
        // $response = Http::get('https://jsonplaceholder.typicode.com/users');
        // $users = $response->json();

        // if (!empty($users)) {
        //     foreach ($users as $key => $user) {
        //         if (!User::where('email', $user['email'])->exists()) {
        //             User::create([
        //                 'name' => $user['name'],
        //                 'email' => $user['email'],
        //                 'password' => bcrypt('123456789')
        //             ]);
        //         }
        //     }
        // }


        return 0;
        $this->info('Successfully sent daily quote to everyone.');

        $data["email"] = "benchapol@pico.co.th";
        // $pay_date = "20 ".$this->ThaiMonthYear($date_now);
        $data["title"] = "บิลค่าไฟประจำเดือน ";
        $data["body"] = "This is for testing email using smtp.";
        $files = [
            public_path('pdf/2022-05_1654016400.pdf')
        ];
        Mail::send('mailForm.billingSendEmail', compact('data'), function ($message) use ($data, $files) {
            $message->to($data["email"])
                ->subject($data["title"]);

            foreach ($files as $file) {
                $message->attach($file);
            }
        });
        $this->info('Successfully sent daily quote to everyone.');
    }
}
