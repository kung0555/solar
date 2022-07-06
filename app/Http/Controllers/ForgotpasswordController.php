<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon; 
use Illuminate\Support\Str;

class ForgotpasswordController extends Controller
{
    public function showForgot()
    {

        // return view('customauth.passwords.email');
        return view('/auth/forgot_password');
    }

    public function forgotChk(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        // $token = str_random(64);
        $token = Str::random(64);

        DB::table('password_resets')->insert(
            ['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]
        );
        // $email = $request->email;
        $email = urlencode($request->email);
        // $urlemail = "?email=$email";

        Mail::send('mailForm.mailForgotpassword',compact('token','email'), function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Reset Password Notification');
        });

        return back()->with('message', 'We have e-mailed your password reset link!');
    }
}
